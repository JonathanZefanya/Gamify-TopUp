<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogDetails;
use App\Models\Language;
use App\Traits\Upload;
use Illuminate\Http\Request;
use App\Rules\AlphaDashWithoutSlashes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    use Upload;

    public function index()
    {
        $data['defaultLanguage'] = Language::where('default_status', true)->first();
        $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
        $data['blogs'] = Blog::with('category', 'details')->orderBy('id', 'desc')->paginate(10);
        return view('admin.blogs.list', $data);
    }


    public function create()
    {
        $data['blogCategory'] = BlogCategory::orderBy('id', 'desc')->get();
        $data['defaultLanguage'] = Language::where('default_status', true)->first();
        $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
        return view('admin.blogs.create', $data);
    }

    public function store(Request $request)
    {

        $request->validate([
            'category_id' => 'required|numeric|not_in:0|exists:blog_categories,id',
            'title' => 'required|string|min:3|max:200',
            'slug' => 'required|string|min:3|max:200|alpha_dash|unique:blogs,slug',
            'description' => 'required|string|min:3',
            'description_image' => 'required|mimes:png,jpg,jpeg|max:50000',
        ]);
        try {
            if ($request->hasFile('description_image')) {
                $descriptionImage = $this->fileUpload($request->description_image, config('filelocation.blog.path'), null, config('filelocation.blog.preview_img'), 'webp', null);
                throw_if(empty($descriptionImage['path']), 'Description image could not be uploaded.');
            }
            if ($request->hasFile('banner_image')) {
                $bannerImage = $this->fileUpload($request->banner_image, config('filelocation.blog.path'), null, config('filelocation.blog.banner_img'), 'webp', null);
                throw_if(empty($bannerImage['path']), 'Banner image could not be uploaded.');
            }

            $response = Blog::create([
                'category_id' => $request->category_id,
                'slug' => $request->slug,
                'blog_image' => $descriptionImage['path'] ?? null,
                'blog_image_driver' => $descriptionImage['driver'] ?? null,
                'banner_image' => $bannerImage['path'] ?? null,
                'banner_image_driver' => $bannerImage['driver'] ?? null,
            ]);

            throw_if(!$response, 'Something went wrong while storing blog data. Please try again later.');


            $response->details()->create([
                "title" => $request->title,
                'language_id' => $request->language_id,
                'description' => $request->description,
            ]);

            return back()->with('success', 'Blog saved successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function blogEdit($id, $language = null)
    {
        $blog = Blog::with(['details' => function ($query) use ($language) {
            $query->where('language_id', $language);
        }])
            ->where('id', $id)
            ->firstOr(function () {
                throw new \Exception('Blog not found');
            });

        $data['pageEditableLanguage'] = Language::where('id', $language)->select('id', 'name', 'short_name')->first();
        $data['defaultLanguage'] = Language::where('default_status', true)->first();
        $data['blogCategory'] = BlogCategory::orderBy('id', 'desc')->get();
        $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
        return view('admin.blogs.edit', $data, compact('blog', 'language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function blogUpdate(Request $request, $id, $language)
    {
        $request->validate([
            'category_id' => 'required|numeric|not_in:0|exists:blog_categories,id',
            'title' => 'required|string|min:3|max:1000',
            'description' => 'nullable|string|min:3',
            'description_image' => 'nullable|mimes:png,jpg,jpeg|max:50000',
            'banner_image' => 'nullable|mimes:png,jpg,jpeg|max:50000',
        ]);

        try {
            $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
                throw new \Exception('Blog not found');
            });

            if ($request->hasFile('description_image')) {
                $descriptionImage = $this->fileUpload($request->description_image, config('filelocation.blog.path'), null, config('filelocation.blog.preview_img'), 'webp', null, $blog->blog_image, $blog->blog_image_driver);
                throw_if(empty($descriptionImage['path']), 'Description image could not be uploaded.');
            }

            if ($request->hasFile('banner_image')) {
                $bannerImage = $this->fileUpload($request->banner_image, config('filelocation.blog.path'), null, config('filelocation.blog.banner_img'), 'webp', null, $blog->banner_image, $blog->banner_image_driver);
                throw_if(empty($bannerImage['path']), 'Banner image could not be uploaded.');
            }

            $response = $blog->update([
                'category_id' => $request->category_id,
                'slug' => $request->slug ?? $blog->slug,
                'blog_image' => $descriptionImage['path'] ?? $blog->blog_image,
                'blog_image_driver' => $descriptionImage['driver'] ?? $blog->blog_image_driver,
                'banner_image' => $bannerImage['path'] ?? $blog->banner_image,
                'banner_image_driver' => $bannerImage['driver'] ?? $blog->banner_image_driver,
            ]);

            throw_if(!$response, 'Something went wrong while storing blog data. Please try again later.');

            $blog->details()->updateOrCreate([
                'language_id' => $language,
            ],
                [
                    "title" => $request->title,
                    'description' => $request->description,
                ]
            );

            return back()->with('success', 'Blog saved successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function destroy(string $id)
    {
        try {
            $blog = Blog::where('id', $id)->firstOr(function () {
                throw new \Exception('No blog data found.');
            });

            $blogDetails = BlogDetails::where('blog_id', $id)->get();
            if ($blogDetails->count() > 0) {
                foreach ($blogDetails as $blogDetail) {
                    $blogDetail->delete();
                }
            }

            $blog->delete();
            return redirect()->back()->with('success', 'Blog deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function slugUpdate(Request $request)
    {

        $rules = [
            "blogId" => "required|exists:blogs,id",
            "newSlug" => ["required", "min:1", "max:100",
                new AlphaDashWithoutSlashes(),
                Rule::unique('blogs', 'slug')->ignore($request->blogId),
                Rule::notIn(['login', 'register', 'signin', 'signup', 'sign-in', 'sign-up'])
            ],
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $blogId = $request->blogId;

        $newSlug = $request->newSlug;
        $blog = Blog::find($blogId);

        if (!$blog) {
            return back()->with("error", "Blog not found");
        }

        $blog->slug = $newSlug;
        $blog->save();

        return response([
            'success' => true,
            'slug' => $blog->slug
        ]);
    }

    public function blogSeo(Request $request, $id)
    {
        try {
            $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
                throw new \Exception('Blog not found');
            });
            return view('admin.blogs.seo', compact('blog'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function blogSeoUpdate(Request $request, $id)
    {
        $request->validate([
            'page_title' => 'required|string|min:3|max:100',
            'meta_title' => 'required|string|min:3|max:100',
            'meta_keywords' => 'required|array',
            'meta_keywords.*' => 'required|string|min:1|max:300',
            'meta_description' => 'required|string|min:1|max:300',
            'seo_meta_image' => 'sometimes|required|mimes:jpeg,png,jpeg|max:10240'
        ]);

        try {

            $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
                throw new \Exception('Blog not found');
            });

            if ($request->hasFile('meta_image')) {
                try {
                    $image = $this->fileUpload($request->meta_image, config('filelocation.pageSeo.path'), null, null, 'webp', 80,$blog->meta_image, $blog->meta_image_driver);
                    if ($image) {
                        $pageSEOImage = $image['path'];
                        $pageSEODriver = $image['driver'] ?? 'local';
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Meta image could not be uploaded.');
                }
            }

            $blog->update([
                'page_title' => $request->page_title,
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description,
                'meta_image' => $pageSEOImage ?? $blog->meta_image,
                'meta_image_driver' => $pageSEODriver ?? $blog->meta_image_driver,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', 'Seo has been updated.');
    }
    public function status($id){

        try {
            $blog = Blog::select('id', 'status')
                ->where('id', $id)
                ->firstOr(function () {
                    throw new \Exception('Blog not found.');
                });

            $blog->status = ($blog->status == 1) ? 0 : 1;
            $blog->save();

            return back()->with('success','Blog Status Changed Successfully.');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }

}
