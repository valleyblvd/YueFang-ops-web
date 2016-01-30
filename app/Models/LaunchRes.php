<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaunchRes extends Model
{
    protected $table = 'launch_res';

    public function toViewModel()
    {
        $this->type_display = $this->getTypeDisplay($this->type);
        $this->active_display = $this->active ? '是' : '否';
        $formats = [];
        $resources = [];
        if ($this->type != 3) {
            $formats = explode(',', $this->format);
            foreach ($formats as $fmt) {
                $resource = new \stdClass();
                $resource->format = $fmt;
                $resource->imgs = [];
                for ($i = 1; $i <= $this->num; $i++) {
                    $relativePath = $this->img . '_' . $fmt . '_' . $i . '.' . $this->ext;
                    $img = new \stdClass();
                    $img->relativePath = $relativePath;
                    $img->src = env('UPLOAD_URL') . $relativePath;
                    $resource->imgs[] = $img;
                }
                $resources[] = $resource;
            }
        }
        $this->formats = $formats;
        $this->resources = $resources;
        return $this;
    }

    private function getTypeDisplay($type)
    {
        switch ($type) {
            case 0:
                return '启动屏幕图片';
            case 1:
                return '启动广告图片';
            case 2:
                return '引导图片';
            case 3:
                return '首页Html';
            default:
                return '未知';
        }
    }
}
