<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    // Menampilkan form (Bisa untuk buat baru ATAU edit revisi)
    public function create()
    {
        return view('proposal.form');
    }

    // Menyimpan proposal baru pertama kali
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'category' => 'required|string',
            'event_date' => 'required|date',
            'budget' => 'required|numeric|min:0',
            'description' => 'required|string',
            'document' => 'required|file|mimes:pdf,docx,xlsx|max:10240',
        ]);

        $filePath = $request->file('document')->store('proposals_berkas', 'public');

        Proposal::create([
            'title' => $request->title,
            'division' => $request->division,
            'category' => $request->category,
            'event_date' => $request->event_date,
            'budget' => $request->budget,
            'description' => $request->description,
            'document' => $filePath,
            'status' => 'menunggu_bph',
        ]);

        return redirect()->route('proposal.list')->with('success', 'Proposal baru berhasil diajukan ke BPH!');
    }

    // Membuka form yang sama dengan memuat data proposal lama untuk direvisi
    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('proposal.form', compact('proposal'));
    }

    // Memproses data revisi + validasi wajib upload ulang dokumen
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'category' => 'required|string',
            'event_date' => 'required|date',
            'budget' => 'required|numeric|min:0',
            'description' => 'required|string',
            'document' => 'required|file|mimes:pdf,docx,xlsx|max:10240', 
        ], [
            'document.required' => 'Dokumen revisi terbaru wajib diunggah kembali!',
        ]);

        $proposal = Proposal::findOrFail($id);

        if ($proposal->document) {
            Storage::disk('public')->delete($proposal->document);
        }

        $filePath = $request->file('document')->store('proposals_berkas', 'public');

        $proposal->update([
            'title' => $request->title,
            'division' => $request->division,
            'category' => $request->category,
            'event_date' => $request->event_date,
            'budget' => $request->budget,
            'description' => $request->description,
            'document' => $filePath,
            'status' => 'menunggu_bph', 
        ]);

        return redirect()->route('proposal.list')->with('success', 'Proposal revisi berhasil dikirim ulang ke BPH!');
    }

    public function proposalList()
    {
        $proposals = Proposal::latest()->get();
        
        // Ambil data proposal terakhir milik user/staff untuk keperluan notifikasi sistem
        $latestProposal = Proposal::latest()->first(); 

        return view('proposal.index', compact('proposals', 'latestProposal'));
    }

    public function show(Proposal $proposal)
    {
        return view('proposal.show', compact('proposal'));
    }

    public function review()
    {
        $proposals = Proposal::whereIn('status', ['menunggu_bpi', 'butuh revisi'])->latest()->get();
        return view('proposal.review', compact('proposals'));
    }

    public function approveBph($id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->update([
            'status' => 'menunggu_bpi',
            'notes' => null
        ]);
        return redirect()->back()->with('success', 'Proposal disetujui BPH dan diteruskan ke BPI.');
    }

    public function revisiBph(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $proposal = Proposal::findOrFail($id);
        $proposal->update([
            'status' => 'butuh revisi',
            'notes' => $request->notes
        ]);
        return redirect()->back()->with('warning', 'Proposal dikembalikan ke Staff untuk direvisi.');
    }

    public function approveBpi($id)
    {
        $proposal = Proposal::findOrFail($id);
        if (!in_array(strtolower($proposal->status), ['menunggu_bpi', 'butuh revisi'])) {
            return redirect()->back()->with('error', 'Status proposal tidak valid untuk disetujui.');
        }

        $proposal->update([
            'status' => 'approved',
            'notes' => null
        ]);
        return redirect()->back()->with('success', 'Proposal resmi disetujui (Approved Finansial BPI).');
    }

    public function revisiBpi(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $proposal = Proposal::findOrFail($id);
        if (!in_array(strtolower($proposal->status), ['menunggu_bpi', 'butuh revisi'])) {
            return redirect()->back()->with('error', 'Status proposal tidak valid untuk direvisi.');
        }

        $proposal->update([
            'status' => 'butuh revisi', 
            'notes' => '[REVISI BPI]: ' . $request->notes
        ]);
        return redirect()->back()->with('warning', 'Proposal ditolak oleh BPI dan dikembalikan ke Staff untuk direvisi.');
    }
}