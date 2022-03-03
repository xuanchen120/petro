<?php

namespace XuanChen\Petro\Controllers\Admin;

use Auth;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use XuanChen\Petro\Models\PetroCoupon;

class CouponController extends AdminController
{

    protected $title = '中石油优惠券管理';

    /**
     * Notes:
     *
     * @Author: <C.Jason>
     * @Date  : 2019/9/18 14:50
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PetroCoupon());

        $grid->disableActions();
        $grid->disableCreateButton();

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {
            $filter->column(1 / 2, function ($filter) {
                $filter->equal('mobile', '手机号');
                $filter->equal('couponNo', '电子券请求码');
                $filter->between('useTime', '核销时间')->datetime();
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->equal('status', '状态')->select(PetroCoupon::STATUS);
                $filter->like('stationName', '核销站点名称');
                $filter->like('stationCode', '核销站点编号');
            });
        });

        $grid->column('id', '#ID#');
        $grid->column('mobile', '手机号');
        $grid->column('couponNo', '券码');
        $grid->column('amount', '面额(分)');
        $grid->column('requestCode', '电子券请求码');
        $grid->column('effectiveTime', '生效时间');
        $grid->column('status', '状态')->using(PetroCoupon::STATUS)->label();
        $grid->column('expiredDate', '失效日期');
        $grid->column('stationName', '核销站点名称');
        $grid->column('stationCode', '核销站点编号');
        $grid->column('useTime', '核销时间');
        $grid->column('goodsInfo', '详情')->hide();
        $grid->column('created_at', '获取时间');
        $grid->disableExport(false);

        $grid->export(function ($export) {
            $export->column('mobile', function ($value, $original) {
                return $value."\t";
            });
            $export->column('couponNo', function ($value, $original) {
                return $value."\t";
            });
            $export->column('status', function ($value, $original) {
                return strip_tags($value);
            });
            $export->filename($this->title.date("YmdHis"));
        });

        return $grid;
    }

}
