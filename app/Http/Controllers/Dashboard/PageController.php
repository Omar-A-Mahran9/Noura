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
        // Update page details
        $page->update([
            'title' => $data['title']
        ]);

        // Process Sections
        $existingSections = $page->sections->keyBy('id');

        foreach ($request->sections as $sectionIndex => $sectionData) {
            $sectionId = $sectionData['id'] ?? null;

            $sectionDetails = [
                'page_id' => $page->id,
                'title' => $sectionData['title'],
                'description' => $sectionData['description'] ?? null,
            ];

            // Handle Section Image Upload
            if (!empty($sectionId) && $request->hasFile("sections.$sectionIndex.image")) {
                $existingSection = $existingSections[$sectionId] ?? null;
                if ($existingSection && $existingSection->image) {
                    deleteImage($existingSection->image, 'sections'); // Delete old image
                }
                $sectionDetails['image'] = uploadImage($request->file("sections.$sectionIndex.image"), 'sections');
            }

            if ($sectionId && isset($existingSections[$sectionId])) {
                // Update existing section
                $existingSections[$sectionId]->update($sectionDetails);
                $section = $existingSections[$sectionId];
            } else {
                // Create new section
                $section = SectionPage::create($sectionDetails);
            }

            // Process Section Items
            $existingItems = $section->items->keyBy('id');

            foreach ($sectionData['items'] ?? [] as $itemIndex => $itemData) {
                $itemId = $itemData['id'] ?? null;

                $itemDetails = [
                    'section_id' => $section->id,
                    'title' => $itemData['title'],
                    'description' => $itemData['description'] ?? null,
                ];

                // Handle Item Image Upload
                if (!empty($itemId) && $request->hasFile("sections.$sectionIndex.items.$itemIndex.image")) {
                    $existingItem = $existingItems[$itemId] ?? null;
                    if ($existingItem && $existingItem->image) {
                        deleteImage($existingItem->image, 'items'); // Delete old image
                    }
                    $itemDetails['image'] = uploadImage($request->file("sections.$sectionIndex.items.$itemIndex.image"), 'items');
                }

                if ($itemId && isset($existingItems[$itemId])) {
                    // Update existing item
                    $existingItems[$itemId]->update($itemDetails);
                } else {
                    // Create new item
                    SectionItem::create($itemDetails);
                }
            }
        }

     }

}
