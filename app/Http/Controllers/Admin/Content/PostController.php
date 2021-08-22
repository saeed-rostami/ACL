<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\ValidationException;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
//            VALIDATION REQUEST
            $this->validation($request, 'store');

//            STORE IMAGE FILE
            $image_name = $request->name . $request->image->getClientOriginalName();
            $request->file('image')->storeAs('images/content/post', $image_name, 'public');

//            PREPARE AND STORE TAGS
            $tags = $this->prepareTags($request);

            $category = PostCategory::query()
                ->where('name', $request->category)
                ->first();

//            STORE FINALLY
            $post = new Post();
            $post->title = $request->title;
            $post->category_id = $category->id;
            $post->slug = Str::slug($request->title);
            $post->body = $request->body;
            $post->summary = $request->summary;
            $post->status = $request->status;
            $post->commentable = $request->commentable;
            $post->tags = $tags;
            $post->published_at = Carbon::now();
//            $post->author_id = 3;
//            TODO USERS TABLES SHOULD NOT BE EMPTY
            $post->image = $image_name;
            $post->save();

            $img = Image::make('storage/images/content/post/' . $image_name)->resize('525', '295');
            $img->save();

            //RESPONSE
            return response()->json([
                'message' => 'با موفقیت ایجاد شد',
                'status' => 200
            ]);
        } catch (ValidationException $error) {
            return response($error->errors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            //            VALIDATION REQUEST
            $this->validation($request, 'update');
            $post = Post::query()->find($id);

            //            STORE IMAGE FILE
            if ($request->hasFile('image')) {
                File::delete("storage/images/content/post/" . $post->image);
                $image_name = $request->title . $request->image->getClientOriginalName();

                $request->file('image')->storeAs('images/content/post', $image_name, 'public');
                $img = Image::make('storage/images/content/post/' . $image_name)->resize('525', '295');
                $img->save();
            } else {
                $image_name = $post->image;
            }

            //            PREPARE AND STORE TAGS
            $tags = $this->prepareTags($request);

            $categoryID = $this->getCategory($request);

            //            STORE FINALLY
            $post->update([
                'title' => $request->title,
                'category_id' => $categoryID,
                'slug' => Str::slug($request->title),
                'body' => $request->body,
                'summary' => $request->summary,
                'status' => $request->status,
                'commentable' => $request->commentable,
                'published_at' => Carbon::now(),
                'tags' => $tags,
                'image' => $image_name
            ]);


            //RESPONSE
            return response()->json([
                'message' => 'با موفقیت ایجاد شد',
                'status' => 200
            ]);
        } catch (ValidationException $error) {
            return response($error->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::query()->find($id);
        $post->delete();
        return response()->json([
            'message' => 'با موفقیت حذف شد',
            'status' => 200
        ]);
    }

    protected function validation(Request $request, $method)
    {
        if ($method == 'store') {
            $this->validate($request, [
                'title' => 'required|string|:max:32|min:2',
                'category' => 'required',
                'body' => 'required|string|min:5',
                'summary' => 'required|string|min:5',
                'image' => 'image:mimes:jpg,png,jpeg|max:2048',
                'status' => 'required',
                'commentable' => 'required',
                'tags' => 'string'
            ]);
        } else {
            $this->validate($request, [
                'title' => 'required|string|:max:32|min:2',
                'category' => 'required',
                'body' => 'required|string|min:5',
                'summary' => 'required|string|min:5',
                'status' => 'required',
                'commentable' => 'required',
                'tags' => 'string'
            ]);
        }

    }

    protected function prepareTags(Request $request)
    {
        $arrayTags = explode(',', $request->tags);
        foreach ($arrayTags as $tag) {
            $tags[] = $tag;
        }
        return $tags;
    }

    /**
     * @param Request $request
     * @return int|mixed|string
     */
    protected function getCategory(Request $request)
    {
        if (is_numeric($request->category)) {
            $categoryID = $request->category;
        } else {
            $category = PostCategory::query()
                ->where('name', $request->category)
                ->first();
            $categoryID = $category->id;
        }
        return $categoryID;
    }
}