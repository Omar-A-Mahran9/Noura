<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ConsultationWork;
use Illuminate\Http\Request;

class ConsultationWorkController extends Controller
{


    public function edit($id)
    {
        $consultationWork = ConsultationWork::with('steps')->findOrFail($id);

        return view('dashboard.consultationwork.edit', compact('consultationWork'));
    }


    public function update(Request $request, $id)
    {
        $consultationWork = ConsultationWork::findOrFail($id);

        // Validate the request
        $data=    $request->validate([
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'steps.*.name' => 'required|string|max:255',
            'steps.*.description' => 'nullable|string',
            'steps.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        // Handle main image upload
        if ($request->hasFile('main_image')) {
            // Delete old main image
            deleteImage($consultationWork->main_image, 'consultation_work');

            // Upload new image using helper function
            $data['main_image'] = uploadImage($request->file('main_image'), 'consultation_work');
        }

        // Process steps data
        $stepsData = [];
        foreach ($request->steps as $index => $step) {
            $stepData = [
                'name' => $step['name'],
                'description' => $step['description'] ?? null,
            ];

            // Handle step image upload
            if ($request->hasFile("steps.$index.image")) {
                // Delete old step image
                deleteImage($consultationWork->steps[$index]['image'] ?? null, 'steps');

                // Upload new image using helper function
                $stepData['image'] = uploadImage($request->file("steps.$index.image"), 'steps');
            } else {
                // Keep old image if not changed
                $stepData['image'] = $consultationWork->steps[$index]['image'] ?? null;
            }

            $stepsData[] = $stepData;
        }
dd($data);
        // Update consultation work record
        $consultationWork->update($data + ['steps' => $stepsData]);

        return redirect()->route('dashboard.consultation_work.index')->with('success', 'Consultation Work updated successfully.');
    }

    public function destroy($id)
    {
        //
    }
}
