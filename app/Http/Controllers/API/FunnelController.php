<?php

namespace App\Http\Controllers\API;

use App\Funnel;
use Illuminate\Http\Request;
use App\Events\FunnelCompleted;
use App\Http\Controllers\Controller;
use Flugg\Responder\Facades\Responder;
use App\Transformers\FunnelTransformer;
use Watson\Validating\ValidationException;

class FunnelController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Get all of the funnel.
     *
     * @return Response
     */
    public function index(Request $request) {

        $funnels = Funnel::where('user_id', $request->user()->id);

        $limit = $request->has('limit') ? $request->get('limit') : 5;
        $funnels = $funnels->paginate($limit);

        return Responder::success($funnels, new FunnelTransformer)
                        ->with('tags')
                        ->respond();
    }

    public function filter(Request $request) {
        $funnels = Funnel::where('user_id', $request->user()->id);
        if ($tags = $request->get('tags')) {
            foreach ($tags as $tag) {
                $funnels = $funnels->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tags.id', $tag);
                });
            }
        }
        if ($expire = $request->get('expire')) {
            switch ($expire) {
                case 'expired':
                    $funnels = $funnels->where('ends_at', '<', date('Y-m-d H:i:s'));
                    break;
                case 'lowCoupons':
                    $funnels = $funnels->where('no_of_coupons', '<', 5);
                    break;
                case 'expireSoon':
                    $funnels = $funnels
                            ->where('ends_at', '<', date('Y-m-d H:i:s', strtotime('+ 1 day')))
                            ->where('ends_at', '>', date('Y-m-d H:i:s'));
                    break;
            }
        }
        $limit = $request->has('limit') ? $request->get('limit') : 5;

        $funnels = $funnels->paginate($limit);


        return Responder::success($funnels, new FunnelTransformer)
                        ->with('tags')
                        ->respond();
    }

    public function show(Funnel $funnel, Request $request) {
        return Responder::success($funnel, new FunnelTransformer)
                        ->with('tags')
                        ->respond();
    }

    /**
     * Create a new Funnel.
     *
     * @return Response
     */
    public function store(Request $request) { //var_dump($request->all());exit;
        try {
            $funnel = Funnel::make($request->all(), $request->user()->id);
            return Responder::success($funnel, new FunnelTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    /**
     * 
     * @param Funnel $funnel
     * @param Request $request
     * @return type
     */
    public function update(Funnel $funnel, Request $request) {
        try {
            Funnel::updateFunnel($funnel, $request->all());
            return Responder::success($funnel, new FunnelTransformer)->respond();
        } catch (ValidationException $e) {
            return Responder::error($this->validationErrorResponse($e));
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    /**
     * Destroy the given funnel.
     *
     * @param  Request  $request
     * @param  Funnel  $funnel
     * @return Response
     */
    public function destroy(Request $request, Funnel $funnel) {

        try {
            $result = $funnel->delete();
            if ($result) {

                return Responder::success();
            }

            return Responder::error('Funnel was not deleted!');
        } catch (\Exception $e) {
            return Responder::error($e->getMessage());
        }
    }

    public static function Routes() {

        \Route::group(['prefix' => 'funnels'], function () {
            \Route::get('/', 'API\FunnelController@index');
            \Route::get('{funnel}', 'API\FunnelController@show')->middleware('can:view,funnel');
            \Route::post('/', 'API\FunnelController@store');
            \Route::post('/filter', 'API\FunnelController@filter');
            \Route::delete('{funnel}', 'API\FunnelController@destroy')->middleware('can:delete,funnel');
            \Route::post('{funnel}', 'API\FunnelController@update')->middleware('can:update,funnel');
        });
    }

}
