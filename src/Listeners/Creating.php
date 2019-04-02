<?php

namespace Wildside\Userstamps\Listeners;

use Tymon\JWTAuth\JWTAuth;

class Creating {

    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }


    /**
     * When the model is being created.
     *
     * @param Illuminate\Database\Eloquent $model
     * @return void
     */
    public function handle($model)
    {
        if (! $model -> isUserstamping()) {
            return;
        }

        if (is_null($model -> {$model -> getCreatedByColumn()})) {
            // $model -> {$model -> getCreatedByColumn()} = auth() -> id();
            if(!is_null($this->jwt->user())) {
              $model -> {$model -> getUpdatedByColumn()} = $this->jwt->user()->id;
            }
        }

        if (is_null($model -> {$model -> getUpdatedByColumn()}) && ! is_null($model -> getUpdatedByColumn())) {
            // $model -> {$model -> getUpdatedByColumn()} = auth() -> id();
            if(!is_null($this->jwt->user())) {
              $model -> {$model -> getUpdatedByColumn()} = $this->jwt->user()->id;
            }
        }
    }
}
