doc控制器方法 image::cache() 生成文件缩略图，把文件保存在url对应的位置，下次访问web服务器会直接载入缓存的图片 <br>
参数1 style 图像样式 在配置文件config/imagestyle.php中设定 <br>
原图url: http://localhost/ggphp/demo/image/goodzsq.jpg <br>
生成使用样式为icon的缓存缩略图: http://localhost/ggphp/demo/image/cache/icon/image/goodzsq.jpg <br>