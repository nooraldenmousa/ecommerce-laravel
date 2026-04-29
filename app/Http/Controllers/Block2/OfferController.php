<?php

namespace App\Http\Controllers\Block2;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\PersonalInformation;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all();
        return view('offers.index', compact('offers'));
    }

    public function create()
    {
        return view('offers.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'offer_name' => 'required|string|max:50',
        'offer_details' => 'nullable|string|max:200',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'status' => 'nullable|string|max:50',
    ]);

    Offer::create($request->all());

    return redirect()->route('marketing.offers.index')->with('success', 'تم إضافة العرض بنجاح');
}
  public function show($id)
{
    $offer = Offer::findOrFail($id);
    $vipCustomers = PersonalInformation::where('customer_type_id', 2)->get();
    return view('offers.show', compact('offer', 'vipCustomers'));
}

    public function edit($id)
    {
        $offer = Offer::findOrFail($id);
        return view('offers.edit', compact('offer'));
    }

    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);

        $request->validate([
            'offer_name' => 'required|string|max:50',
            'offer_details' => 'nullable|string|max:200',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $offer->update($request->all());
        return redirect()->route('marketing.offers.index')->with('success', 'تم تعديل العرض بنجاح');
    }

    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();
        return redirect()->route('marketing.offers.index')->with('success', 'تم حذف العرض بنجاح');
    }
    public function assignStore(Request $request, $id)
{
    $offer = Offer::findOrFail($id);
    $offer->customers()->sync($request->customer_ids);
    return redirect()->route('marketing.offers.show', $id)->with('success', 'تم توزيع العرض بنجاح');
}
}