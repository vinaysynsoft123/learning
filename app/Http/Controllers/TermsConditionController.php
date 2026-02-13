<?php

namespace App\Http\Controllers;

use App\Models\TermsCondition;
use App\Models\Destination;
use Illuminate\Http\Request;

class TermsConditionController extends Controller
{
    public function index()
    {
        $terms = TermsCondition::with('destination')->latest()->get();
        return view('terms_conditions.index', compact('terms'));
    }

    public function create()
    {
        $destinations = Destination::active()->get();
        return view('terms_conditions.form', [
            'term' => null,
            'destinations' => $destinations
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination_id'   => 'required|exists:destinations,id',
            'terms_conditions' => 'nullable|string',
            'privacy_policy'   => 'nullable|string',
            'status'           => 'required|boolean',
        ]);

        TermsCondition::create($request->all());

        return redirect()->route('terms-conditions.index')
            ->with('success', 'Terms & Conditions added successfully');
    }

    public function edit(TermsCondition $termsCondition)
    {
        $destinations = Destination::active()->get();
        return view('terms_conditions.form', [
            'term' => $termsCondition,
            'destinations' => $destinations
        ]);
    }

    public function update(Request $request, TermsCondition $termsCondition)
    {
        $request->validate([
            'destination_id'   => 'required|exists:destinations,id',
            'terms_conditions' => 'nullable|string',
            'privacy_policy'   => 'nullable|string',
            'status'           => 'required|boolean',
        ]);

        $termsCondition->update($request->all());

        return redirect()->route('terms-conditions.index')
            ->with('success', 'Terms & Conditions updated successfully');
    }

    public function destroy(TermsCondition $termsCondition)
    {
        $termsCondition->delete();

        return redirect()->route('terms-conditions.index')
            ->with('success', 'Terms & Conditions deleted successfully');
    }
}
