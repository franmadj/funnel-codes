<?php

namespace App\Http\Controllers\API;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Flugg\Responder\Facades\Responder;
use App\Transformers\TagTransformer;
use Watson\Validating\ValidationException;

class TagController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Get all of the tag.
     *
     * @return Response
     */
    public function all(Request $request) {
        if ($request->has('q')) {
            return Tag::where('user_id', $request->user()->id)->where('name', 'like', '%' . $request->get('q') . '%')->get();
        }
        if ($request->has('filter')) {
            
            $tags = Tag::where('user_id', $request->user()->id)->get();
        } else {
            $limit = $request->has('limit') ? $request->get('limit') : 5;
            $tags = Tag::where('user_id', $request->user()->id)->paginate($limit);
        }


        return Responder::success($tags, new TagTransformer)->respond();
    }

    /**
     * Create a new Tag.
     *
     * @return Response
     */
    public function store(Request $request) { //var_dump($request->all());exit;
        try {
            $tag = Tag::make($request->all(), $request->user()->id);
            return Responder::success($tag, new TagTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    /**
     * 
     * @param Tag $tag
     * @param Request $request
     * @return type
     */
    public function update(Tag $tag, Request $request) {
        try {
            Tag::updateTag($tag, $request->all());
            return Responder::success($tag, new TagTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    /**
     * Destroy the given tag.
     *
     * @param  Request  $request
     * @param  Tag  $tag
     * @return Response
     */
    public function destroy(Request $request, Tag $tag) {

        try {
            $result = $tag->delete();
            if ($result) {
                return Responder::success();
            }

            return Responder::error('Tag was not deleted!');
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    public static function Routes() {

        \Route::group(['prefix' => 'tags'], function () {
            \Route::get('/', 'API\TagController@all');
            \Route::post('/', 'API\TagController@store');
            \Route::delete('{tag}', 'API\TagController@destroy');
            \Route::post('{tag}', 'API\TagController@update');
        });
    }

}
