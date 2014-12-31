$('.clearDd').show();

var okSelect = []; //已经选择好的
var oSelectList = document.getElementById('selectList');

var oClearList = $(".hasBeenSelected .clearList");
var oCustext1 = document.getElementById('custext1');
var oCustext2 = document.getElementById('custext2');
var aItemTxt = oSelectList.getElementsByTagName('a');
var isCusPrice = false;//是否自定义价格
var radioVal = '';
var filter_list = [];
var _page_index =0;
var _cur_page_min = 1;
var _cur_page_max = 10;
var _has_pref  = 0;
var _pref_index = 1;
var _has_next = 0;
var _next_index = 0;
//浏览器判定
var is_ie9 = false;
if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE6.0")
{
  //alert("IE 6.0");
}
else if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE7.0")
{
  //alert("IE 7.0");
}
else if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE8.0")
{
  //alert("IE 8.0");
}
else if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE9.0")
{
  //alert("IE 9.0");
  is_ie9 = true;
} 

oSelectList.onclick = function(e, a) {
    var ev = e || window.event;
    var tag = ev.target || ev.srcElement;
    if(!tag)return;
    var tagName = tag.nodeName.toUpperCase();
    var infor = '';
    var aRadio = document.getElementsByName('radio2');

    if( isCusPrice ) {
      radioVal = oCustext1.value + '-' + oCustext2.value + '元';
    } else {
      radioVal = '';
    }

    if (tagName == 'INPUT') {
       /*
        if (tag.getAttribute('type').toUpperCase() == 'CHECKBOX') { //如果点击 的是 input checkbox
            var val = next(tag);
            if (tag.checked) {
                var sType = prev(parents(tag, 'dd')).innerHTML;
                val && okSelect.push(trim(val.innerHTML) + '|' + sType)
                //添加属性值
                filter_list.push(val.getAttribute('values1'));
            } else {
                var sType = prev(parents(tag, 'dd')).innerHTML;
                delStr(val.innerHTML + '|' + sType, okSelect)
                //删除属性值
                delStr(val.getAttribute('values1'), filter_list)
            }
            _page_index = 0;
            //回调商品信息
            call_goods_by_filter();
        } else if (tag.getAttribute('type').toUpperCase() == 'BUTTON') { //如果点击的是 自定义价格按钮
            radioVal = oCustext1.value + '-' + oCustext2.value + '元';
            isCusPrice = true;

            for (var i = 0; i < aRadio.length; i++) {
                aRadio[i].checked = false;
            }

        }
       */
    }
    if (tagName == 'IMG'){
        var parent_tag = parents(tag,'A');
        var parent_parent_tag = prev(parent_tag);
        var sType = prev(parents(parent_tag, 'dd')).innerHTML;
        parent_parent_tag.checked = false;
        parent_parent_tag.value = 0;
        //删除属性值
        delStr(parent_tag.getAttribute('values1'), filter_list);
        if(undefined == parent_tag.innerText)
            delStr(parent_tag.textContent + '|' + sType, okSelect);
        else
            delStr(parent_tag.innerText + '|' + sType, okSelect);
        reinit_page();

        //回调商品信息
        call_goods_by_filter();
        $(parent_tag).removeClass("title_p_e");
    }

    if (tagName == 'A') { //如果点击 的是 A
        var oPrevInput = prev(tag);
        if (!oPrevInput) { //如果上一个节点没有则认为点击的是 '不限'
            var parent = parents(tag, 'dd');
            var aItem = parent.getElementsByTagName('label');
            if(parent.getAttribute('data-more')) {
                var allCheckbox = next(parents(parent, 'dl')).getElementsByTagName('label');
                var sType = '';
                for (var i = 0, len = allCheckbox.length; i < len; i++) {
                    sType = prev(parents(allCheckbox[i], 'dd')).innerHTML;
                    delStr(text(allCheckbox[i]) + '|' + sType, okSelect);
                    allCheckbox[i].children[0].checked = false;
                }
            }

            if (trim(prev(parent).innerHTML) == '酒店价格') { //这里是直接根据 text来比较的.建议加个自定义属性作标识符
                for (var i = 0; i < aRadio.length; i++) {
                    aRadio[i].checked = false;
                }
                isCusPrice = false;
                a = true;
                radioVal = '';
            } else {
                var sType = '';
                for (var i = 0, len = aItem.length; i < len; i++) {
                    sType = prev(parents(aItem[i], 'dd')).innerHTML;
                    delStr(text(aItem[i]) + '|' + sType, okSelect);
                    aItem[i].children[0].checked = false;
                    aItem[i].children[0].value = 0;
                    $(aItem[i].children[1]).removeClass("title_p_e");
                    if($(aItem[i].children[1]).attr('values1'))
                        delStr($(aItem[i].children[1]).attr('values1'), filter_list)
                }
                call_goods_by_filter();
            }

        } else {

            if (oPrevInput && oPrevInput.getAttribute('type').toUpperCase() == 'RADIO') { //radio
                isCusPrice = false;
                oPrevInput.checked = true;
            }

            if (oPrevInput && oPrevInput.getAttribute('type').toUpperCase() == 'CHECKBOX') { //获取checkbox
                //if (oPrevInput.checked==true) {
                  if (oPrevInput.value==1) {  
                    //if(is_ie9)
                    //    oPrevInput.setAttribute("checked")=false;
                    //else
                    //oPrevInput.checked = false;
                    //oPrevInput.setAttribute("checked", false);
                    oPrevInput.value = 0;
                    var sType = prev(parents(tag, 'dd')).innerHTML;
                    if(undefined == tag.innerText)
                        delStr(tag.textContent + '|' + sType, okSelect);
                    else
                        delStr(tag.innerText + '|' + sType, okSelect);
                    //删除属性值
                    delStr(tag.getAttribute('values1'), filter_list)
                    $(tag).removeClass("title_p_e");
                } else {
                    //if(is_ie9)
                    //    oPrevInput.setAttribute("checked") = true;
                    //else
                    //   oPrevInput.checked = true;                    
                   // oPrevInput.checked = true;
                   //oPrevInput.setAttribute("checked", true);
                   oPrevInput.value = 1;
                   //oPrevInput.checked = true;
                    var sType = prev(parents(tag, 'dd')).innerHTML;                    
                    if(undefined == tag.innerText)
                        okSelect.push(trim(tag.textContent) + '|' + sType);
                    else
                        okSelect.push(trim(tag.innerText) + '|' + sType);
                    //添加属性值
                    $(tag).addClass("title_p_e");
                    filter_list.push(tag.getAttribute('values1'));
                }
                reinit_page();
                //回调商品信息
                call_goods_by_filter();
            }
        }
    };

    for (var i = 0; i < aRadio.length; i++) {
        if (aRadio[i].checked) {
            radioVal = next(aRadio[i]).innerHTML;
            isCusPrice = false;
            break;
        }
    }

    if(a) {
         isCusPrice = false;
    }

    if(a && a == 2) {
        for (var i = 0; i < aRadio.length; i++) {
            aRadio[i].checked = false;
        }
           
    } else {
       if (radioVal) infor += '<div class=\"selectedInfor selectedShow\"><span>酒店价格</span><label>' + radioVal + '</label><em p="2"></em></div>';
    }


    var vals = [];
    for (var i = 0,
    size = okSelect.length; i < size; i++) {
        vals = okSelect[i].split('|');
        infor += '<div class=\"selectedInfor selectedShow\"><span>' + vals[1] + '</span><span class=\"labels\">' + vals[0] + '</span><em onclick="test(this);"></em></div>';
    }
    oClearList.html(infor);
};
$('div.eliminateCriteria').click(function(){
    $(oSelectList).find('input').attr('checked',false);
    $(oSelectList).find('input').val(0);
    $(oSelectList).find('a').removeClass("title_p_e");
    radioVal = '';
    isCusPrice = false;
    okSelect.length = 0;
    $(oSelectList).trigger('click', 1);
    filter_list = [];
    call_goods_by_filter();
})

function test(obj_this)
{
    var self = $(obj_this);
    var val = self.prev().html() + '|' + self.prev().prev().html();
    var n = -1;
    var a = obj_this.getAttribute('p') || 1;
    self.die('click');
    for(var i = 0, len = aItemTxt.length; i < len; i++) {
         var html = val.split('|')[0];
         var content = '';
         if(aItemTxt[i].innerText)
            content = aItemTxt[i].innerText;
         else
            content = aItemTxt[i].textContent;
         if(trim(content) == html) {
              prev(aItemTxt[i]).checked = false;
              prev(aItemTxt[i]).value   = 0;
              break;
        }        
    };    
    delStr(val, okSelect);
    $(oSelectList).trigger('click', a);
    $(aItemTxt[i]).removeClass("title_p_e");
    //删除属性值
    delStr($(aItemTxt[i]).attr('values1'), filter_list);
    reinit_page();
    call_goods_by_filter();
}

$('#clearList').find('em').live('click',function(){
    var self = $(this);
    var val = self.prev().html() + '|' + self.prev().prev().html();
    var n = -1;
    var a = this.getAttribute('p') || 1;
    self.die('click');
    for(var i = 0, len = aItemTxt.length; i < len; i++) {
         var html = val.split('|')[0];
         var content = '';
         if(aItemTxt[i].innerText)
            content = aItemTxt[i].innerText;
         else
            content = aItemTxt[i].textContent;
         if(trim(content) == html) {
              prev(aItemTxt[i]).checked = false;
              prev(aItemTxt[i]).value = 0;
              break;
        }        
    };
    delStr(val, okSelect);
    $(oSelectList).trigger('click', a);
})

function delStr(str, arr) { //删除数组给定相同的字符串
    var n = -1;
    for (var i = 0,
    len = arr.length; i < len; i++) {
        if (str == arr[i]) {
            n = i;
            break;
        }
    }
    n > -1 && arr.splice(n, 1);
};
function trim(str) {
    return str.replace(/^\s+|\s+$/g, '')
};
function text(e) {
    var t = '';
    e = e.childNodes || e;
    for (var j = 0; j < e.length; j++) {
        t += e[j].nodeType != 1 ? e[j].nodeValue: text(e[j].childNodes);
    }
    return trim(t);
}

function prev(elem) {
    do {
        elem = elem.previousSibling;
    } while ( elem && elem . nodeType != 1 );
    return elem;
};

function next(elem) {
    do {
        elem = elem.nextSibling;
    } while ( elem && elem . nodeType != 1 );
    return elem;
}

function parents(elem, parents) {  //查找当前祖先辈元素需要的节点  如 parents(oDiv, 'dd') 查找 oDiv 的祖先元素为dd 的
    if(!elem || !parents) return;
    var parents = parents.toUpperCase();
    do{
        elem = elem.parentNode;
    } while( elem.nodeName.toUpperCase() != parents );
    return elem;
};

function reinit_page()
{
    _cur_page_min = 1;
    _cur_page_max = 10;
    _page_index   = 0;
    _has_pref     = 0;
    _pref_index   = 1;
    _has_next     = 0;
    _next_index   = 0;
}
