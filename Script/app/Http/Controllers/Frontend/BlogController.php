<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogDetails;
use App\Models\Content;
use App\Models\Page;
use App\Models\PageDetail;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function blog(Request $request, $slug = null)
    {
        $page = Page::where('name', 'blog')->where('template_name', getTheme())->first();

        $data['pageSeo'] = [
            'page_title' => $page->page_title,
            'meta_title' => $page->meta_title,
            'meta_keywords' => implode(',', $page->meta_keywords ?? []),
            'meta_description' => $page->meta_description,
            'og_description' => $page->og_description,
            'meta_robots' => $page->meta_robots,
            'meta_image' => getFile($page->meta_image_driver, $page->meta_image),
            'breadcrumb_image' => $page->breadcrumb_status ?
                getFile($page->breadcrumb_image_driver, $page->breadcrumb_image) : null,
        ];

        $data['blogs'] = Blog::with('category', 'details')
            ->when($slug != null, function ($query) use ($slug) {
                $query->whereHas('category', function ($qq) use ($slug) {
                    $qq->where('slug', $slug);
                });
            })
            ->when(isset($request->search),  function ($query) use ($request) {
                $query->whereHas('details', function ($qq) use($request) {
                    $qq->where('title', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(basicControl()->paginate);


        return view(template() . 'blog', $data);
    }

    public function blogDetails(Request $request, $slug)
    {
        $data['pageSeo']['page_title'] = 'Blog Details';
        $data['blogDetails'] = BlogDetails::with('blog')
            ->whereHas('blog', function ($query) use($slug) {
                $query->where('slug', $slug);
            })->firstOrFail();

        $data['popularContentDetails'] = BlogDetails::with('blog')
            ->where('id', '!=', $data['blogDetails']->id)
            ->when(isset($request->title), function ($query) use ($request) {
                return $query->where('title', 'LIKE', '%' . $request->title . '%');
            })
            ->take(3)->latest()
            ->get();

        $data['categories'] = BlogCategory::withCount(['blogs'])->get();

        $blogDetails = $data['blogDetails'];
        $data['pageSeo'] = [
            'page_title' => optional($blogDetails->blog)->page_title,
            'meta_title' => optional($blogDetails->blog)->meta_title,
            'meta_keywords' => implode(',', optional($blogDetails->blog)->meta_keywords ?? []),
            'meta_description' => optional($blogDetails->blog)->meta_description,
            'og_description' => optional($blogDetails->blog)->og_description,
            'meta_robots' => optional($blogDetails->blog)->meta_robots,
            'meta_image' => getFile(optional($blogDetails->page)->meta_image_driver, optional($blogDetails->blog)->meta_image),
            'breadcrumb_image' => optional($blogDetails->blog)->breadcrumb_status ?
                getFile(optional($blogDetails->page)->breadcrumb_image_driver, optional($blogDetails->blog)->breadcrumb_image) : null,
        ];

        return view(template() . 'blog_details', $data);
    }
}
