<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use Storage;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = request()->query();

        $categories = Category::with('parent')
            ->withCount([
                'products' => function ($query) {
                    $query->where('status' , '=', 'active');
                }
            ])
            // ->select('categories.*')
            // ->selectRaw('(SELECT COUNT(*) FROM products WHERE products.category_id = categories.id) as products_count')
            ->filter($filters)
            ->paginate(3);

        return view('dashboard.categories.index', compact('categories'));
    }
                    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->except('image');
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('categories', 'public');
            }

                $data['slug'] = $this->generateUniqueSlug($request->name);

            Category::create($data);

            \DB::commit();
            return redirect()->route('categories.index')->with('success', 'Successfully Created Category');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->route('categories.index')->with('error', 'Category creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        return view('dashboard.categories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);

            $categories = Category::where('id', '<>', $id)->get();

            return view('dashboard.categories.edit', compact('category', 'categories'));

        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Category not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,'.$id,
                'parent_id' => 'nullable|exists:categories,id',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'status' => 'required|in:active,inactive',
            ]);

            $category = Category::findOrFail($id);

            \DB::beginTransaction();

            if ($request->hasFile('image')) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $validated['image'] = $request->file('image')->store('categories', 'public');
            }

            $validated['slug'] = $this->generateUniqueSlug($request->name, $id);

            $category->update($validated);

            \DB::commit();
            return redirect()->route('categories.index')->with('success', 'Category updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->route('categories.index')->with('error', 'Category update failed!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            if (Category::where('parent_id', $id)->exists()) {
                return redirect()->route('categories.index')->with('error', 'Cannot delete category with subcategories!');
            }
            $category->delete();



            return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Category could not be deleted!');
        }
    }


    private function generateUniqueSlug($name, $id = null)
    {
        $slug = Str::slug($name);
        $count = Category::where('slug', 'LIKE', "{$slug}%")->where('id', '!=', $id)->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(10);
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        Category::withTrashed()->where('id', $id)->restore();
        return redirect()->route('categories.trash')->with('success', 'Category restored successfully.');
    }

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->where('id', $id)->firstOrFail()->forceDelete();
            if($category->image) {
                Storage::disk('public')->delete($category->image);
            }

        return redirect()->route('categories.trash')->with('success', 'Category deleted permanently.');
    }

    public function active()
    {
        $filters = request()->query();
        $filters['status'] = 'active';

        $categories = Category::with('parent')
            ->select('categories.*')
            ->selectRaw('(SELECT COUNT(*) FROM Products WHERE category_id =  categories.id) as products_count')
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM products WHERE products.category_id = categories.id) AS products_count'))
            ->filter($filters)
            // ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            // ->select([
            //     'categories.*',
            //     'parents.name as parent_name'
            // ])
            ->paginate(3);

        return view('dashboard.categories.active', compact('categories'));
    }

    public function archived()
    {
        $filters = request()->query();
        $filters['status'] = 'inactive';

        $categories = Category::filter($filters)
            ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])
            ->paginate(3);


        return view('dashboard.categories.archived', compact('categories'));
    }



}
