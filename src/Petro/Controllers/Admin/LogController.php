<?php

namespace XuanChen\Petro\Controllers\Admin;

use App\Models\User;
use Auth;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use XuanChen\Petro\Models\PetroLog;

class LogController extends AdminController
{

    protected $title = '中石油日志';

    /**
     * Notes:
     *
     * @Author: <C.Jason>
     * @Date  : 2019/9/18 14:50
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PetroLog());

        $grid->disableActions();
        $grid->disableCreateButton();
        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {
            $filter->column(1 / 2, function ($filter) {
                $filter->equal('type', '类型')->select(PetroLog::TYPES);
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->like('out_source', '优惠券');
            });
        });

        $grid->column('id', '#ID#');

        $grid->column('type', '类型')->using(PetroLog::TYPES)->label();
        $grid->column('in_source', '入参')->width(350);
        $grid->column('out_source', '出参')->width(350);
        $grid->column('created_at', '操作时间');
        return $grid;
    }

}
