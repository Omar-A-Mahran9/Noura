<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdateConsultationWorkRequest;
use App\Models\ConsultationWork;
use App\Models\ConsultationWorkStep;
use Illuminate\Http\Request;

class ConsultationWorkController extends Controller
{


    public function edit($id)
    {
        $consultationWork = ConsultationWork::with('steps')->findOrFail($id);

        return view('dashboard.consultationwork.edit', compact('consultationWork'));
    }


    public function update(UpdateConsultationWorkRequest $request, $id)
    {
        $consultationWork = ConsultationWork::with('steps')->findOrFail($id);
        $data = $request->validated();

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            deleteImage($consultationWork->main_image, 'consultation_work'); // Delete old image
            $data['main_image'] = uploadImage($request->file('main_image'), 'consultation_work'); // Upload new image
        }

        // Update Consultation Work
        $consultationWork->update([
            'main_image' => $data['main_image'] ?? $consultationWork->main_image,
        ]);
        $existingSteps = $consultationWork->steps->keyBy('id'); // Store existing steps by ID

        // Process steps
        foreach ($request->steps as $index => $step) {
 
            $stepId = $step['id'] ?? null; // Get the ID if exists

            $stepData = [
                'consultation_work_id' => $consultationWork->id,
                'name' => $step['name'],
                'description' => $step['description'] ?? null,
            ];

            // Handle step image upload
            if ($request->hasFile("steps.$index.image")) {
                $stepData['image'] = uploadImage($request->file("steps.$index.image"), 'steps');
            }

            if ($stepId && isset($existingSteps[$stepId])) {
                // Update existing step
                $existingStep = $existingSteps[$stepId];

                if (isset($stepData['image'])) {
                    deleteImage($existingStep->image, 'steps'); // Delete old image if new image is uploaded
                }

                $existingStep->update($stepData);
            } else {
                // Create new step if no valid ID is found
                ConsultationWorkStep::create($stepData);
            }
        }
    }



    public function destroy($id)
    {
        //
    }
}
