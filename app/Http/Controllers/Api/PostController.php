<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePost;
use App\Http\Resources\PostResource;
use App\Jobs\DeleteImage;
use App\Models\Category;
use App\Models\Favor;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;


class PostController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/posts",
     *     summary="Get list of blog posts",
     *     tags={"Posts"},
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="pagination number",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/PostResource")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
  public function getAllPosts()
  {
      $posts = Post::paginate(5);
      return PostResource::collection($posts);
  }

    /**
     * @SWG\Get(
     *     path="/user/{user}/posts",
     *     summary="Get list of user's blog posts",
     *     tags={"Posts"},
     *     @SWG\Parameter(
     *         name="user",
     *         in="path",
     *         description="user id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/PostResource")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */

  public function getAllUserPosts(User $user)
  {
    $posts = $user->posts;
    return PostResource::collection($posts);
  }

    /**
     * @SWG\Get(
     *     path="/category/{category}/posts",
     *     summary="Get list of blog posts in certainly category",
     *     tags={"Posts"},
     *     @SWG\Parameter(
     *         name="category",
     *         in="path",
     *         description="category id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/PostResource")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */

    public function getAllCategoryPosts(Category $category)
    {
        $result = Category::descendantsAndSelf($category->id)->pluck('id')->toArray();
        $posts = Post::whereIn('category_id', $result)->get();
        return PostResource::collection($posts);
    }

    /**
     * @SWG\Get(
     *     path="/favorites/posts",
     *     summary="Get list of blog posts in my favorites",
     *     tags={"Posts"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/PostResource")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */

    public function getAllMyFavoritePosts(Request $request)
    {
        $favorites = $request->user()->favorites()->pluck('posts_id')->toArray();
        $posts = Post::whereIn('id', $favorites)->get();
        return PostResource::collection($posts);
    }
    /**
     * @SWG\Get(
     *     path="/post/{post}",
     *     summary="Get blog post by id",
     *     tags={"Posts"},
     *     description="Get blog post by id",
     *     @SWG\Parameter(
     *         name="post",
     *         in="path",
     *         description="Post id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/PostResource"),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Post is not found",
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
    public function getPost(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * @SWG\Post(
     *     path="/create/post",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     @SWG\Parameter(name="image", in="formData", type="file" ,required=false),
     *     @SWG\Parameter(name="name", in="formData", type="string" ,required=true),
     *     @SWG\Parameter(name="category_id", in="formData", type="string" ,required=true),
     *     @SWG\Parameter(name="text", in="formData", type="string" ,required=true),
     *     @SWG\Response(
     *         response=200,
     *         description="You success create post",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Error create post",
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
    public function createPost(CreatePost $request)
    {
        try{
            $data = $request->only(['name','category_id','text'])+['user_id'=>$request->user()->id];
            $image = ['image'=>$request->file('image')->store('images','public')];
            Post::create(array_merge($data,$image));
        }catch (\Exception $exception)
        {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
        return response()->json([
            'message' => __('messages.SuccessCreatePost')
        ], 201);
    }
    /**
     * @SWG\Delete(
     *     path="/delete/post/{post}",
     *     summary="Delete a post",
     *     tags={"Posts"},
     *     @SWG\Parameter(
     *         name="post",
     *         in="path",
     *         description="Post id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="You success delete post"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Error delete post",
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
    public function deleteMyPost(Post $post)
    {
        try{
            $image = $post->image;
            $post->delete();
            DeleteImage::dispatch($image);
            return response()->json([
                'message' => __('messages.SuccessDeletePost')
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
    /**
     * @SWG\Post(
     *     path="/add/favor/{post}",
     *     summary="Add a post to favorites",
     *     tags={"Posts"},
     *     @SWG\Parameter(name="post", in="path", type="string",required=true, @SWG\Schema(
     *  @SWG\Property(
     *     property="post",
     *     type="string",
     *     description="post id"
     *  ),
     * )),
     *  @SWG\Response(
     *         response="404",
     *         description="Post already add to favorites or You can't add your post to favorites post",
     *     ),
     *    @SWG\Response(
     *         response="201",
     *         description="You success add post to favor",
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */

    public function addPostToFavorite(Request $request, Post $post)
    {
        try{
            $isYourPost = $request->user()->posts()->where('id',$post->id)->count();
            $isAlreadyExists = Favor::where([
                ['user_id',$request->user()->id],
                ['posts_id',$post->id]
            ])->count();
            if($isAlreadyExists){
                throw new \Exception(__('messages.PostAlreadyAddToFavor'));
            }
            if($isYourPost){
                throw new \Exception(__('messages.ErrorAddFavorPost'));
            }

            $favor = new Favor;

            $favor->user_id = $request->user()->id;
            $favor->posts_id = $post->id;

            $favor->save();
        }catch (\Exception $exception)
        {
            return response()->json([
                'message' => $exception->getMessage()
            ], 404);
        }
        return response()->json([
        'message' => __('messages.AddFavorPost')
        ], 201);
    }

    /**
     * @SWG\Delete(
     *     path="/delete/favor/{post}",
     *     summary="Delete a post form favorites",
     *     tags={"Posts"},
     *     @SWG\Parameter(
     *         name="post",
     *         in="path",
     *         description="Post id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="You success delete post from favorites"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Post is not your",
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */

    public function deletePostFromFavorite(Request $request, Post $post)
    {
        try{
            $isYourPost = Favor::where([
                ['user_id',$request->user()->id],
                ['posts_id',$post->id]
            ])->count();
            if(!$isYourPost){
                throw new \Exception(__('messages.PostIsNotYour'));
            }
            Favor::where('posts_id',$post->id)->where('user_id',$request->user()->id)->delete();

        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 404);
        }
        return response()->json([
            'message' => __('messages.SuccessDeletePostFromFavorites')
        ], 204);
    }
}
