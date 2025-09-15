<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Loan;
use App\Models\Verification;
use App\Models\User;
use App\Models\Offer;
use App\Models\Settings;
use SweetAlert2\Laravel\Swal;

class BorrowerController extends Controller
{
    public function dashboard(){
    
        $activeLoans = auth()->user()->loans->filter(fn($loan) => $loan->status === 'active');

        $totalActiveAmount = $activeLoans
            ->flatMap(fn($loan) => $loan->offers)
            ->sum('repayment_amount');

        $tenor = $activeLoans->first()->tenor ?? 0;

        $creditScore = auth()->user()->borrower->credit_score ?? 0;
        $gradeSetting = \App\Models\Settings::where('min_score', '<=', $creditScore)
                        ->where('max_score', '>=', $creditScore)
                        ->first();
        $maxLimit = $gradeSetting ? $gradeSetting->max_loan_amount : 0;
        return view('dashboard', ['maxLimit'=>$maxLimit, 'totalActiveAmount'=> $totalActiveAmount, 'tenor'=>$tenor]);
    }

    public function index()
    {
        $loans = Loan::where('user_id', auth()->id())
                 ->latest()
                 ->paginate(10);

        return view('borrower-list', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $creditScore = auth()->user()->borrower->credit_score ?? 0;
        $gradeSetting = \App\Models\Settings::where('min_score', '<=', $creditScore)
                        ->where('max_score', '>=', $creditScore)
                        ->first();
        $verification = auth()->user()->status;
        if (!$gradeSetting || $verification !== "verified") {
            return redirect()->route('dashboard');
        }

        return view('borrower-create', compact('gradeSetting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try {
        $creditScore = auth()->user()->borrower->credit_score ?? 0;
        $gradeSetting = \App\Models\Settings::where('min_score', '<=', $creditScore)
                        ->where('max_score', '>=', $creditScore)
                        ->first();

        $request->validate([
            'amount' => "required|numeric|min:100000|max:{$gradeSetting->max_loan_amount}",
            'tenor'  => "required|integer|min:1|max:{$gradeSetting->max_tenor_months}",
            'purpose'=> 'required|string|max:1000',
        ]);

        $monthlyRate = $gradeSetting->interest_rate / 100 / 12;
        $amount = $request->amount;
        $tenor = $request->tenor;

        Loan::create([
            'user_id' => auth()->id(),
            'amount' => $amount,
            'tenor' => $tenor,
            'purpose' => $request->purpose,
            'interest_rate' => $gradeSetting->interest_rate,
            'status' => 'requested',
        ]);

        return redirect()->route('borrower.list')->with('success', 'Loan application submitted!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loan = Loan::find($id);

        abort_if($loan->user_id !== auth()->id(), 403);

        return view('borrower-show', compact('loan'));
    }

public function update($offerId)
{
    DB::transaction(function() use ($offerId) {
        $approvedOffer = Offer::with('loan')->findOrFail($offerId);
        $loan = $approvedOffer->loan;

        $approvedOffer->status = 'accepted';
        $approvedOffer->save();

        $totalAccepted = Offer::where('loan_id', $loan->id)
                            ->where('status', 'accepted')
                            ->sum('repayment_amount');

        $remaining = $loan->amount - $totalAccepted;

        $pendingOffers = Offer::where('loan_id', $loan->id)
                            ->where('status', 'offering')
                            ->orderBy('created_at')
                            ->get();

        foreach ($pendingOffers as $pendingOffer) {
            if ($remaining <= 0) {
                $pendingOffer->repayment_amount = 0;
                $pendingOffer->save();
                continue;
            }

            if ($pendingOffer->repayment_amount > $remaining) {
                $pendingOffer->repayment_amount = $remaining;
            }

            $remaining -= $pendingOffer->repayment_amount;
            $pendingOffer->save();
        }
    });

    return back()->with('success', 'Offer berhasil diapprove dan alokasi lender lain diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function verify(string $id)
    {
        return view('borrower-verify', ['user_id'=>$id]);
    }

    public function submitVerification(Request $request)
    {
         $request->validate([
            'user_id' => 'required',
            'nik' => 'required|string|min:16|max:16',
            'slip_gaji' => 'required|string|max:8',
            'phone_number' => 'required|string|min:8|max:15',
        ]);
        $user = User::find($request->user_id);
        Verification::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'nik' => $request->nik,
                'slip_gaji' => $request->slip_gaji,
                'phone_number' => $request->phone_number,
            ]
        );

        $user->status = 'requested';
        $user->save();
        Swal::fire([
            'title' => 'Pengajuan telah dikirim!',
            'text' => 'Proses verifikasi maksimal 48 jam.',
            'icon' => 'success',
            'confirmButtonText' => 'Oke saya mengerti'
        ]);
        return redirect()->route('dashboard');
    }

    public function disbursed(Request $request, $id)
    {
        $loan = Loan::find($id);
        $loan->update([
            'status' => 'active',
            'disbursed_amount' => $request->disbursed_amount,
            'disbursed_at' => now(),
        ]);
        Swal::fire([
            'title' => 'Pencairan dana telah disetujui',
            'text' => 'Proses pencairan dana maksimal 24 jam.',
            'icon' => 'success',
            'confirmButtonText' => 'Oke saya mengerti'
        ]);
        return redirect()->route('dashboard');
    }
}
