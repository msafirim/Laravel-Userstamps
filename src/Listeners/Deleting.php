<?php

namespace Wildside\Userstamps\Listeners;

use Tymon\JWTAuth\JWTAuth;

class Deleting {

    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * When the model is being deleted.
     *
     * @param Illuminate\Database\Eloquent $model
     * @return void
     */
    public function handle($model)
    {
        if (! $model -> isUserstamping()) {
            return;
        }

        if (is_null($model -> {$model -> getDeletedByColumn()})) {
            // $model -> {$model -> getDeletedByColumn()} = auth() -> id();
            if(!is_null($this->jwt->user())) {
              $model -> {$model -> getUpdatedByColumn()} = $this->jwt->user()->id;
            }
        }

        $dispatcher = $model -> getEventDispatcher();

        $model -> unsetEventDispatcher();

        $model -> save();

        $model -> setEventDispatcher($dispatcher);
    }
}
