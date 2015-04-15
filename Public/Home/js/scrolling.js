var scrolling = function (option) {
    this.speed = option.speed || 40;//滚动速度
    this.dir = option.dir.toLowerCase() || "left";//滚动方向，默认是向左滚动
    this.obj = option.obj;//滚动东西，必须参数
    this.distance = option.distance || 0;//对象内元素的总滚动距离
    this.Init();//初始化
}
scrolling.prototype.Init = function () {
    var _this = this;
    var childrenCount = this.obj.children().length;
    //如果子元素少于2个，不滚动
    if (childrenCount < 2) {
        return;
    }
    //为对象加上绝对定位
    _this.obj.css("position", "absolute");
    _this.distance = 0;
    //获取子元素的总的滚动距离
    $.each(_this.obj.children(), function (i, o) {
        _this.distance += _this.dir === "left" ? $(o).outerWidth(true) : $(o).outerHeight(true);
    });
    _this.obj.css(_this.dir === "left" ? "width" : "height", _this.distance);
    if (_this.dir === "top") {
        _this.obj.children().css({ "display": "block", "float": "none" });
    }
    _this.obj.bind("mouseenter", function () {
        $(this).animate().stop();
    });
    _this.obj.bind("mouseleave", function () {
        _this.beginScroll();
    });
    _this.beginScroll();
}
scrolling.prototype.beginScroll = function () {
    var _this = this;
    _this.obj.animate(_this.dir === "left" ? { left: "-=1px" } : { top: "-=1px" }, this.speed, "", function () {
        var first = _this.obj.children().first();
        var dis = _this.dir === "left" ? first.outerWidth(true) : first.outerHeight(true);
        if (parseInt($(this).css(_this.dir).replace("px", "")) === -dis) {
            _this.obj.append(first.clone());
            _this.obj.css(_this.dir, "0px");
            first.remove();
        }
        _this.beginScroll();
    });
}
scrolling.prototype.stopScroll = function () {
    $(this).animate().stop();
}