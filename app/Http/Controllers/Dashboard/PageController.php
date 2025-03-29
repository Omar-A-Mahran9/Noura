<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdatePageRequest;
use App\Models\Page;
use App\Models\SectionItem;
use App\Models\SectionPage;

class PageController extends Controller
{

    public function edit($id)
    {
        $page = Page::with('sections')->findOrFail($id);

        return view('dashboard.page.edit', compact('page'));
    }


    public function update(UpdatePageRequest $request, $id)
    {
         $page = Page::with('sections.items')->findOrFail($id);
        $data = $request->validated();

        // Get existing sections indexed by ID
        $existingSections = $page->sections->keyBy('id');
        foreach ($data['sections'] as $sectionIndex => $sectionData) {

            if (isset($sectionData['id']) && isset($existingSections[$sectionData['id']])) {

                $section = $existingSections[$sectionData['id']];

                // Update section details
                $sectionDetails = [
                    'title' => $sectionData['title'],
                    'description' => $sectionData['description'] ?? null,
                ];

                // Handle Section Image Upload
                if ($request->hasFile("sections.$sectionIndex.image")) {

                    if ($section->image) {
                        deleteImage($section->image, 'sections'); // Delete old image
                    }
                    $sectionDetails['image'] = uploadImage($request->file("sections.$sectionIndex.image"), 'sections');
                 }

                $section->update($sectionDetails);

                // Get existing items indexed by ID
                $existingItems = $section->items->keyBy('id');
                dd($existingItems);

                foreach ($sectionData['items'] ?? [] as $itemIndex => $itemData) {
                    if (isset($itemData['id']) && isset($existingItems[$itemData['id']])) {
                        $item = $existingItems[$itemData['id']];
                        // Update item details
                        $itemDetails = [
                            'title' => $itemData['title'],
                            'description' => $itemData['description'] ?? null,
                        ];

                        // Handle Item Image Upload
                        if ($request->hasFile("sections.$sectionIndex.items.$itemIndex.image")) {
                            if ($item->image) {
                                deleteImage($item->image, 'items'); // Delete old image
                            }
                            $itemDetails['image'] = uploadImage($request->file("sections.$sectionIndex.items.$itemIndex.image"), 'items');
                        }

                        $item->update($itemDetails);
                    }
                }
            }
        }

           }
    }
