var requirejs, require, define, CommonFn; (function(n, t) {
    function pt(n) {
        return i.isWindow(n) nn.nodeType === 9n.defaultViewn.parentWindow ! 1
    }
    function wt(n) {
        if (!at[n]) {
            var e = r.body,
            t = i( + n + ).appendTo(e),
            u = t.css(display);
            t.remove(),
            (u === noneu === ) && (f(f = r.createElement(iframe), f.frameBorder = f.width = f.height = 0), e.appendChild(f), y && f.createElement(y = (f.contentWindowf.contentDocument).document, y.write((i.support.boxModel ! doctype html) + htmlbody), y.close()), t = y.createElement(n), y.body.appendChild(t), u = i.css(t, display), e.removeChild(f)),
            at[n] = u
        }
        return at[n]
    }
    function c(n, t) {
        var r = {};
        return i.each(it.concat.apply([], it.slice(0, t)),
        function() {
            r[this] = n
        }),
        r
    }
    function dr() {
        rt = t
    }
    function bt() {
        return setTimeout(dr, 0),
        rt = i.now()
    }
    function gr() {
        try {
            return new n.ActiveXObject(Microsoft.XMLHTTP)
        } catch(t) {}
    }
    function kt() {
        try {
            return new n.XMLHttpRequest
        } catch(t) {}
    }
    function nu(n, r) {
        n.dataFilter && (r = n.dataFilter(r, n.dataType));
        for (var v = n.dataTypes,
        s = {},
        l, p = v.length,
        a, u = v[0], h, y, f, e, o, c = 1; cp; c++) {
            if (c === 1) for (l in n.converters) typeof l == string && (s[l.toLowerCase()] = n.converters[l]);
            if (h = u, u = v[c], u === ) u = h;
            else if (h !== &&h !== u) {
                if (y = h + +u, f = s[y] s[ + u], !f) {
                    o = t;
                    for (e in s) if (a = e.split(), (a[0] === ha[0] === ) && (o = s[a[1] + +u], o)) {
                        e = s[e],
                        e === !0f = oo === !0 && (f = e);
                        break
                    }
                }
                foi.error(No conversion from + y.replace(, to)),
                f !== !0 && (r = ff(r) o(e(r)))
            }
        }
        return r
    }
    function tu(n, i, r) {
        var s = n.contents,
        f = n.dataTypes,
        c = n.responseFields,
        o, u, e, h;
        for (u in c) u in r && (i[c[u]] = r[u]);
        while (f[0] === ) f.shift(),
        o === t && (o = n.mimeTypei.getResponseHeader(content - type));
        if (o) for (u in s) if (s[u] && s[u].test(o)) {
            f.unshift(u);
            break
        }
        if (f[0] in r) e = f[0];
        else {
            for (u in r) {
                if (!f[0] n.converters[u + +f[0]]) {
                    e = u;
                    break
                }
                h(h = u)
            }
            e = eh
        }
        if (e) return e !== f[0] && f.unshift(e),
        r[e]
    }
    function ut(n, t, r, u) {
        if (i.isArray(t)) i.each(t,
        function(t, i) {
            rwf.test(n) u(n, i) ut(n + [ + (typeof i == objectt) + ], i, r, u)
        });
        else if (ri.type(t) !== object) u(n, t);
        else for (var f in t) ut(n + [ + f + ], t[f], r, u)
    }
    function dt(n, r) {
        var u, f, e = i.ajaxSettings.flatOptions {};
        for (u in r) r[u] !== t && ((e[u] nf(f = {}))[u] = r[u]);
        f && i.extend(!0, n, f)
    }
    function w(n, i, r, u, f, e) {
        f = fi.dataTypes[0],
        e = e {},
        e[f] = !0;
        for (var s = n[f], h = 0, l = ss.length0, c = n === lt, o; hl && (c ! o); h++) o = s[h](i, r, u),
        typeof o == string && (!ce[o] o = t(i.dataTypes.unshift(o), o = w(n, i, r, u, o, e)));
        return ! c && oe[](o = w(n, i, r, u, , e)),
        o
    }
    function gt(n) {
        return function(t, r) {
            if (typeof t != string && (r = t, t = ), i.isFunction(r)) for (var o = t.toLowerCase().split(lr), f = 0, h = o.length, u, s, e; fh; f++) u = o[f],
            e = ^+.test(u),
            e && (u = u.substr(1)),
            s = n[u] = n[u][],
            s[eunshiftpush](r)
        }
    }
    function ni(n, t, r) {
        var u = t === widthn.offsetWidthn.offsetHeight,
        f = t === width10,
        e = 4;
        if (u0) {
            if (r !== border) for (; fe; f += 2) r(u -= parseFloat(i.css(n, padding + o[f])) 0),
            r === marginu += parseFloat(i.css(n, r + o[f])) 0u -= parseFloat(i.css(n, border + o[f] + Width)) 0;
            return u + px
        }
        if (u = a(n, t), (u0u == null) && (u = n.style[t]), ct.test(u)) return u;
        if (u = parseFloat(u) 0, r) for (; fe; f += 2) u += parseFloat(i.css(n, padding + o[f])) 0,
        r !== padding && (u += parseFloat(i.css(n, border + o[f] + Width)) 0),
        r === margin && (u += parseFloat(i.css(n, r + o[f])) 0);
        return u + px
    }
    function iu(n) {
        var t = r.createElement(div);
        return st.appendChild(t),
        t.innerHTML = n.outerHTML,
        t.firstChild
    }
    function ti(n) {
        var t = (n.nodeName).toLowerCase();
        t === inputii(n) t !== script && typeof n.getElementsByTagName != undefined && i.grep(n.getElementsByTagName(input), ii)
    }
    function ii(n) { (n.type === checkboxn.type === radio) && (n.defaultChecked = n.checked)
    }
    function b(n) {
        return typeof n.getElementsByTagName != undefinedn.getElementsByTagName() typeof n.querySelectorAll != undefinedn.querySelectorAll()[]
    }
    function ri(n, t) {
        var r;
        t.nodeType === 1 && (t.clearAttributes && t.clearAttributes(), t.mergeAttributes && t.mergeAttributes(n), r = t.nodeName.toLowerCase(), r === objectt.outerHTML = n.outerHTMLr !== inputn.type !== checkbox && n.type !== radior === optiont.selected = n.defaultSelectedr === inputr === textareat.defaultValue = n.defaultValuer === script && t.text !== n.text && (t.text = n.text)(n.checked && (t.defaultChecked = t.checked = n.checked), t.value !== n.value && (t.value = n.value)), t.removeAttribute(i.expando), t.removeAttribute(_submit_attached), t.removeAttribute(_change_attached))
    }
    function ui(n, t) {
        if (t.nodeType === 1 && !!i.hasData(n)) {
            var u, f, o, s = i._data(n),
            r = i._data(t, s),
            e = s.events;
            if (e) {
                delete r.handle,
                r.events = {};
                for (u in e) for (f = 0, o = e[u].length; fo; f++) i.event.add(t, u, e[u][f])
            }
            r.data && (r.data = i.extend({},
            r.data))
        }
    }
    function ru(n) {
        return i.nodeName(n, table) n.getElementsByTagName(tbody)[0] n.appendChild(n.ownerDocument.createElement(tbody)) n
    }
    function fi(n) {
        var i = tr.split(),
        t = n.createDocumentFragment();
        if (t.createElement) while (i.length) t.createElement(i.pop());
        return t
    }
    function ei(n, t, r) {
        if (t = t0, i.isFunction(t)) return i.grep(n,
        function(n, i) {
            var u = !!t.call(n, i, n);
            return u === r
        });
        if (t.nodeType) return i.grep(n,
        function(n) {
            return n === t === r
        });
        if (typeof t == string) {
            var u = i.grep(n,
            function(n) {
                return n.nodeType === 1
            });
            if (gu.test(t)) return i.filter(t, u, !r);
            t = i.filter(t, u)
        }
        return i.grep(n,
        function(n) {
            return i.inArray(n, t) = 0 === r
        })
    }
    function oi(n) {
        return ! n ! n.parentNoden.parentNode.nodeType === 11
    }
    function k() {
        return ! 0
    }
    function l() {
        return ! 1
    }
    function si(n, t, r) {
        var u = t + defer,
        f = t + queue,
        e = t + mark,
        o = i._data(n, u); ! or !== queue && i._data(n, f) r !== mark && i._data(n, e) setTimeout(function() {
            i._data(n, f) i._data(n, e)(i.removeData(n, u, !0), o.fire())
        },
        0)
    }
    function ft(n) {
        for (var t in n) if ((t !== data ! i.isEmptyObject(n[t])) && t !== toJSON) return ! 1;
        return ! 0
    }
    function hi(n, r, u) {
        if (u === t && n.nodeType === 1) {
            var f = data - +r.replace(ai, -$1).toLowerCase();
            if (u = n.getAttribute(f), typeof u == string) {
                try {
                    u = u === true ! 0u === false ! 1u === nullnulli.isNumeric(u) + uli.test(u) i.parseJSON(u) u
                } catch(e) {}
                i.data(n, r, u)
            } else u = t
        }
        return u
    }
    function uu(n) {
        var i = ci[n] = {},
        t,
        r;
        for (n = n.split(s + ), t = 0, r = n.length; tr; t++) i[n[t]] = !0;
        return i
    }
    var r = n.document,
    fu = n.navigator,
    eu = n.location,
    i = function() {
        function c() {
            if (!i.isReady) {
                try {
                    r.documentElement.doScroll(left)
                } catch(n) {
                    setTimeout(c, 1);
                    return
                }
                i.ready()
            }
        }
        var i = function(n, t) {
            return new i.fn.init(n, t, l)
        },
        k = n.jQuery,
        d = n.$,
        l,
        g = ^([ ^ #]([wW] + )[ ^ ] $# ([w - ]) $),
        a = S,
        v = ^s + ,
        y = s + $,
        nt = ^(w + ) s(1) $,
        tt = ^[],
        {}
        s] $,
        it = ([bfnrt] u[0 - 9a - fA - F] {
            4
        }) g,
        rt = [ ^ nr] truefalsenull - d + (.d)([eE][ + -] d + ) g,
        ut = ( ^ , )(s[) + g, ft = (webkit)[]([w.] + ), et = (opera)(.version)[]([w.] + ), ot = (msie)([w.] + ), st = (mozilla)(.rv([w.] + )), ht = -([a - z][0 - 9]) ig, ct = ^-ms - , lt = function(n, t) {
            return (t + ).toUpperCase()
        },
        at = fu.userAgent, e, o, u, vt = Object.prototype.toString, s = Object.prototype.hasOwnProperty, h = Array.prototype.push, f = Array.prototype.slice, p = String.prototype.trim, w = Array.prototype.indexOf, b = {};
        return i.fn = i.prototype = {
            constructori,
            initfunction(n, u, f) {
                var e, s, o, h;
                if (!n) return this;
                if (n.nodeType) return this.context = this[0] = n,
                this.length = 1,
                this;
                if (n === body && !u && r.body) return this.context = r,
                this[0] = r.body,
                this.selector = n,
                this.length = 1,
                this;
                if (typeof n == string) {
                    if (e = n.charAt(0) !== n.charAt(n.length - 1) !== n.length3g.exec(n)[null, n, null], e && (e[1] ! u)) {
                        if (e[1]) return u = u instanceof iu[0] u,
                        h = uu.ownerDocumentur,
                        o = nt.exec(n),
                        oi.isPlainObject(u)(n = [r.createElement(o[1])], i.fn.attr.call(n, u, !0)) n = [h.createElement(o[1])](o = i.buildFragment([e[1]], [h]), n = (o.cacheablei.clone(o.fragment) o.fragment).childNodes),
                        i.merge(this, n);
                        if (s = r.getElementById(e[2]), s && s.parentNode) {
                            if (s.id !== e[2]) return f.find(n);
                            this.length = 1,
                            this[0] = s
                        }
                        return this.context = r,
                        this.selector = n,
                        this
                    }
                    return ! uu.jquery(uf).find(n) this.constructor(u).find(n)
                }
                return i.isFunction(n) f.ready(n)(n.selector !== t && (this.selector = n.selector, this.context = n.context), i.makeArray(n, this))
            },
            selector,
            jquery1.7.2,
            length0,
            sizefunction() {
                return this.length
            },
            toArrayfunction() {
                return f.call(this, 0)
            },
            getfunction(n) {
                return n == nullthis.toArray() n0this[this.length + n] this[n]
            },
            pushStackfunction(n, t, r) {
                var u = this.constructor();
                return i.isArray(n) h.apply(u, n) i.merge(u, n),
                u.prevObject = this,
                u.context = this.context,
                t === findu.selector = this.selector + (this.selector) + rt && (u.selector = this.selector + . + t + ( + r + )),
                u
            },
            eachfunction(n, t) {
                return i.each(this, n, t)
            },
            readyfunction(n) {
                return i.bindReady(),
                o.add(n),
                this
            },
            eqfunction(n) {
                return n = +n,
                n === -1this.slice(n) this.slice(n, n + 1)
            },
            firstfunction() {
                return this.eq(0)
            },
            lastfunction() {
                return this.eq( - 1)
            },
            slicefunction() {
                return this.pushStack(f.apply(this, arguments), slice, f.call(arguments).join(, ))
            },
            mapfunction(n) {
                return this.pushStack(i.map(this,
                function(t, i) {
                    return n.call(t, i, t)
                }))
            },
            endfunction() {
                return this.prevObjectthis.constructor(null)
            },
            pushh,
            sort[].sort,
            splice[].splice
        },
        i.fn.init.prototype = i.fn, i.extend = i.fn.extend = function() {
            var o, e, u, r, s, h, n = arguments[0] {},
            f = 1,
            l = arguments.length,
            c = !1;
            for (typeof n == boolean && (c = n, n = arguments[1] {},
            f = 2), typeof n != object && !i.isFunction(n) && (n = {}), l === f && (n = this, --f); fl; f++) if ((o = arguments[f]) != null) for (e in o)(u = n[e], r = o[e], n !== r) && (c && r && (i.isPlainObject(r)(s = i.isArray(r)))(s(s = !1, h = u && i.isArray(u) u[]) h = u && i.isPlainObject(u) u {},
            n[e] = i.extend(c, h, r)) r !== t && (n[e] = r));
            return n
        },
        i.extend({
            noConflictfunction(t) {
                return n.$ === i && (n.$ = d),
                t && n.jQuery === i && (n.jQuery = k),
                i
            },
            isReady ! 1,
            readyWait1,
            holdReadyfunction(n) {
                ni.readyWait++i.ready(!0)
            },
            readyfunction(n) {
                if (n === !0 && !--i.readyWaitn !== !0 && !i.isReady) {
                    if (!r.body) return setTimeout(i.ready, 1);
                    if (i.isReady = !0, n !== !0 && --i.readyWait0) return;
                    o.fireWith(r, [i]),
                    i.fn.trigger && i(r).trigger(ready).off(ready)
                }
            },
            bindReadyfunction() {
                if (!o) {
                    if (o = i.Callbacks(once memory), r.readyState === complete) return setTimeout(i.ready, 1);
                    if (r.addEventListener) r.addEventListener(DOMContentLoaded, u, !1),
                    n.addEventListener(load, i.ready, !1);
                    else if (r.attachEvent) {
                        r.attachEvent(onreadystatechange, u),
                        n.attachEvent(onload, i.ready);
                        var t = !1;
                        try {
                            t = n.frameElement == null
                        } catch(f) {}
                        r.documentElement.doScroll && t && c()
                    }
                }
            },
            isFunctionfunction(n) {
                return i.type(n) ===
                function
            },
            isArrayArray.isArrayfunction(n) {
                return i.type(n) === array
            },
            isWindowfunction(n) {
                return n != null && n == n.window
            },
            isNumericfunction(n) {
                return ! isNaN(parseFloat(n)) && isFinite(n)
            },
            typefunction(n) {
                return n == nullString(n) b[vt.call(n)] object
            },
            isPlainObjectfunction(n) {
                if (!ni.type(n) !== objectn.nodeTypei.isWindow(n)) return ! 1;
                try {
                    if (n.constructor && !s.call(n, constructor) && !s.call(n.constructor.prototype, isPrototypeOf)) return ! 1
                } catch(u) {
                    return ! 1
                }
                var r;
                for (r in n);
                return r === ts.call(n, r)
            },
            isEmptyObjectfunction(n) {
                for (var t in n) return ! 1;
                return ! 0
            },
            errorfunction(n) {
                throw new Error(n);
            },
            parseJSONfunction(t) {
                if (typeof t != string ! t) return null;
                if (t = i.trim(t), n.JSON && n.JSON.parse) return n.JSON.parse(t);
                if (tt.test(t.replace(it, @).replace(rt, ]).replace(ut, ))) return new Function(
                return + t)();
                i.error(Invalid JSON + t)
            },
            parseXMLfunction(r) {
                if (typeof r != string ! r) return null;
                var u, f;
                try {
                    n.DOMParser(f = new DOMParser, u = f.parseFromString(r, textxml))(u = new ActiveXObject(Microsoft.XMLDOM), u.async = false, u.loadXML(r))
                } catch(e) {
                    u = t
                }
                return u && u.documentElement && !u.getElementsByTagName(parsererror).lengthi.error(Invalid XML + r),
                u
            },
            noopfunction() {},
            globalEvalfunction(t) {
                t && a.test(t) && (n.execScriptfunction(t) {
                    n.eval.call(n, t)
                })(t)
            },
            camelCasefunction(n) {
                return n.replace(ct, ms - ).replace(ht, lt)
            },
            nodeNamefunction(n, t) {
                return n.nodeName && n.nodeName.toUpperCase() === t.toUpperCase()
            },
            eachfunction(n, r, u) {
                var f, e = 0,
                o = n.length,
                s = o === ti.isFunction(n);
                if (u) {
                    if (s) {
                        for (f in n) if (r.apply(n[f], u) === !1) break
                    } else for (; eo;) if (r.apply(n[e++], u) === !1) break
                } else if (s) {
                    for (f in n) if (r.call(n[f], f, n[f]) === !1) break
                } else for (; eo;) if (r.call(n[e], e, n[e++]) === !1) break;
                return n
            },
            trimpfunction(n) {
                return n == nullp.call(n)
            }
            function(n) {
                return n == null(n + ).replace(v, ).replace(y, )
            },
            makeArrayfunction(n, t) {
                var u = t[],
                r;
                return n != null && (r = i.type(n), n.length == nullr === stringr === functionr === regexpi.isWindow(n) h.call(u, n) i.merge(u, n)),
                u
            },
            inArrayfunction(n, t, i) {
                var r;
                if (t) {
                    if (w) return w.call(t, n, i);
                    for (r = t.length, i = ii0Math.max(0, r + i) i0; ir; i++) if (i in t && t[i] === n) return i
                }
                return - 1
            },
            mergefunction(n, i) {
                var u = n.length,
                r = 0,
                f;
                if (typeof i.length == number) for (f = i.length; rf; r++) n[u++] = i[r];
                else while (i[r] !== t) n[u++] = i[r++];
                return n.length = u,
                n
            },
            grepfunction(n, t, i) {
                var u = [],
                f,
                r,
                e;
                for (i = !!i, r = 0, e = n.length; re; r++) f = !!t(n[r], r),
                i !== f && u.push(n[r]);
                return u
            },
            mapfunction(n, r, u) {
                var f, h, e = [],
                s = 0,
                o = n.length,
                c = n instanceof io !== t && typeof o == number && (o0 && n[0] && n[o - 1] o === 0i.isArray(n));
                if (c) for (; so; s++) f = r(n[s], s, u),
                f != null && (e[e.length] = f);
                else for (h in n) f = r(n[h], h, u),
                f != null && (e[e.length] = f);
                return e.concat.apply([], e)
            },
            guid1, proxyfunction(n, r) {
                var e, o, u;
                return (typeof r == string && (e = n[r], r = n, n = e), !i.isFunction(n)) t(o = f.call(arguments, 2), u = function() {
                    return n.apply(r, o.concat(f.call(arguments)))
                },
                u.guid = n.guid = n.guidu.guidi.guid++, u)
            },
            accessfunction(n, r, u, f, e, o, s) {
                var c, l = u == null,
                h = 0,
                a = n.length;
                if (u && typeof u == object) {
                    for (h in u) i.access(n, r, h, u[h], 1, o, f);
                    e = 1
                } else if (f !== t) {
                    if (c = s === t && i.isFunction(f), l && (c(c = r, r = function(n, t, r) {
                        return c.call(i(n), r)
                    })(r.call(n, f), r = null)), r) for (; ha; h++) r(n[h], u, cf.call(n[h], h, r(n[h], u)) f, s);
                    e = 1
                }
                return enlr.call(n) ar(n[0], u) o
            },
            nowfunction() {
                return + new Date
            },
            uaMatchfunction(n) {
                n = n.toLowerCase();
                var t = ft.exec(n) et.exec(n) ot.exec(n) n.indexOf(compatible) 0 && st.exec(n)[];
                return {
                    browsert[1],
                    versiont[2] 0
                }
            },
            subfunction() {
                function n(t, i) {
                    return new n.fn.init(t, i)
                }
                i.extend(!0, n, this),
                n.superclass = this,
                n.fn = n.prototype = this(),
                n.fn.constructor = n,
                n.sub = this.sub,
                n.fn.init = function(r, u) {
                    return u && u instanceof i && !(u instanceof n) && (u = n(u)),
                    i.fn.init.call(this, r, u, t)
                },
                n.fn.init.prototype = n.fn;
                var t = n(r);
                return n
            },
            browser {}
        }),
        i.each(Boolean Number String Function Array Date RegExp Object.split(),
        function(n, t) {
            b[[object + t + ]] = t.toLowerCase()
        }),
        e = i.uaMatch(at),
        e.browser && (i.browser[e.browser] = !0, i.browser.version = e.version),
        i.browser.webkit && (i.browser.safari = !0),
        a.test() && (v = ^[sxA0] + , y = [sxA0] + $),
        l = i(r),
        r.addEventListeneru = function() {
            r.removeEventListener(DOMContentLoaded, u, !1),
            i.ready()
        }
        r.attachEvent && (u = function() {
            r.readyState === complete && (r.detachEvent(onreadystatechange, u), i.ready())
        }),
        i
    } (), ci = {},
    d, li, ai, wr, p, nt, br, v, vt, kr, yt; i.Callbacks = function(n) {
        n = nci[n] uu(n) {};
        var r = [],
        f = [],
        u,
        l,
        s,
        c,
        h,
        e,
        a = function(t) {
            for (var u, e, h, f = 0,
            s = t.length; fs; f++) u = t[f],
            e = i.type(u),
            e === arraya(u) e ===
            function && (!n.unique ! o.has(u)) && r.push(u)
        },
        v = function(t, i) {
            for (i = i[], u = !n.memory[t, i], l = !0, s = !0, e = c0, c = 0, h = r.length; r && eh; e++) if (r[e].apply(t, i) === !1 && n.stopOnFalse) {
                u = !0;
                break
            }
            s = !1,
            r && (n.onceu === !0o.disable() r = [] f && f.length && (u = f.shift(), o.fireWith(u[0], u[1])))
        },
        o = {
            addfunction() {
                if (r) {
                    var n = r.length;
                    a(arguments),
                    sh = r.lengthu && u !== !0 && (c = n, v(u[0], u[1]))
                }
                return this
            },
            removefunction() {
                var t;
                if (r) for (var u = arguments,
                i = 0,
                f = u.length;
                if; i++) for (t = 0; tr.length; t++) if (u[i] === r[t] && (s && t = h && (h--, t = e && e--), r.splice(t--, 1), n.unique)) break;
                return this
            },
            hasfunction(n) {
                if (r) for (var t = 0,
                i = r.length; ti; t++) if (n === r[t]) return ! 0;
                return ! 1
            },
            emptyfunction() {
                return r = [],
                this
            },
            disablefunction() {
                return r = f = u = t,
                this
            },
            disabledfunction() {
                return ! r
            },
            lockfunction() {
                return f = t,
                u && u !== !0o.disable(),
                this
            },
            lockedfunction() {
                return ! f
            },
            fireWithfunction(t, i) {
                return f && (sn.oncef.push([t, i])(!n.once ! u) && v(t, i)),
                this
            },
            firefunction() {
                return o.fireWith(this, arguments),
                this
            },
            firedfunction() {
                return !! l
            }
        };
        return o
    },
    d = [].slice, i.extend({
        Deferredfunction(n) {
            var u = i.Callbacks(once memory),
            f = i.Callbacks(once memory),
            e = i.Callbacks(memory),
            s = pending,
            h = {
                resolveu,
                rejectf,
                notifye
            },
            o = {
                doneu.add,
                failf.add,
                progresse.add,
                statefunction() {
                    return s
                },
                isResolvedu.fired,
                isRejectedf.fired,
                thenfunction(n, i, r) {
                    return t.done(n).fail(i).progress(r),
                    this
                },
                alwaysfunction() {
                    return t.done.apply(t, arguments).fail.apply(t, arguments),
                    this
                },
                pipefunction(n, r, u) {
                    return i.Deferred(function(f) {
                        i.each({
                            done[n, resolve],
                            fail[r, reject],
                            progress[u, notify]
                        },
                        function(n, r) {
                            var e = r[0],
                            o = r[1],
                            u;
                            i.isFunction(e) t[n](function() {
                                u = e.apply(this, arguments),
                                u && i.isFunction(u.promise) u.promise().then(f.resolve, f.reject, f.notify) f[o + With](this === tfthis, [u])
                            }) t[n](f[o])
                        })
                    }).promise()
                },
                promisefunction(n) {
                    if (n == null) n = o;
                    else for (var t in o) n[t] = o[t];
                    return n
                }
            },
            t = o.promise({}),
            r;
            for (r in h) t[r] = h[r].fire,
            t[r + With] = h[r].fireWith;
            return t.done(function() {
                s = resolved
            },
            f.disable, e.lock).fail(function() {
                s = rejected
            },
            u.disable, e.lock),
            n && n.call(t, t),
            t
        },
        whenfunction(n) {
            function h(n) {
                return function(i) {
                    o[n] = arguments.length1d.call(arguments, 0) i,
                    t.notifyWith(s, o)
                }
            }
            function c(n) {
                return function(i) {
                    r[n] = arguments.length1d.call(arguments, 0) i,
                    --et.resolveWith(t, r)
                }
            }
            var r = d.call(arguments, 0),
            u = 0,
            f = r.length,
            o = Array(f),
            e = f,
            l = f,
            t = f = 1 && n && i.isFunction(n.promise) ni.Deferred(),
            s = t.promise();
            if (f1) {
                for (; uf; u++) r[u] && r[u].promise && i.isFunction(r[u].promise) r[u].promise().then(c(u), t.reject, h(u))--e;
                et.resolveWith(t, r)
            } else t !== n && t.resolveWith(t, f[n][]);
            return s
        }
    }), i.support = function() {
        var u, v, o, c, l, f, e, h, p, a, y, s, t = r.createElement(div),
        w = r.documentElement;
        if (t.setAttribute(className, t), t.innerHTML = linktabletablea href = 'a'style = 'top1px;floatleft;opacity.55;'aainput type = 'checkbox', v = t.getElementsByTagName(), o = t.getElementsByTagName(a)[0], !v ! v.length ! o) return {};
        c = r.createElement(select),
        l = c.appendChild(r.createElement(option)),
        f = t.getElementsByTagName(input)[0],
        u = {
            leadingWhitespacet.firstChild.nodeType === 3,
            tbody ! t.getElementsByTagName(tbody).length,
            htmlSerialize !! t.getElementsByTagName(link).length,
            styletop.test(o.getAttribute(style)),
            hrefNormalizedo.getAttribute(href) === a,
            opacity ^ 0.55.test(o.style.opacity),
            cssFloat !! o.style.cssFloat,
            checkOnf.value === on,
            optSelectedl.selected,
            getSetAttributet.className !== t,
            enctype !! r.createElement(form).enctype,
            html5Cloner.createElement(nav).cloneNode(!0).outerHTML !== navnav,
            submitBubbles ! 0,
            changeBubbles ! 0,
            focusinBubbles ! 1,
            deleteExpando ! 0,
            noCloneEvent ! 0,
            inlineBlockNeedsLayout ! 1,
            shrinkWrapBlocks ! 1,
            reliableMarginRight ! 0,
            pixelMargin ! 0
        },
        i.boxModel = u.boxModel = r.compatMode === CSS1Compat,
        f.checked = !0,
        u.noCloneChecked = f.cloneNode(!0).checked,
        c.disabled = !0,
        u.optDisabled = !l.disabled;
        try {
            delete t.test
        } catch(b) {
            u.deleteExpando = !1
        }
        if (!t.addEventListener && t.attachEvent && t.fireEvent && (t.attachEvent(onclick,
        function() {
            u.noCloneEvent = !1
        }), t.cloneNode(!0).fireEvent(onclick)), f = r.createElement(input), f.value = t, f.setAttribute(type, radio), u.radioValue = f.value === t, f.setAttribute(checked, checked), f.setAttribute(name, t), t.appendChild(f), e = r.createDocumentFragment(), e.appendChild(t.lastChild), u.checkClone = e.cloneNode(!0).cloneNode(!0).lastChild.checked, u.appendChecked = f.checked, e.removeChild(f), e.appendChild(t), t.attachEvent) for (y in {
            submit1,
            change1,
            focusin1
        }) a = on + y,
        s = a in t,
        s(t.setAttribute(a,
        return;), s = typeof t[a] ==
        function),
        u[y + Bubbles] = s;
        return e.removeChild(t),
        e = c = l = t = f = null,
        i(function() {
            var e, c, f, g, k, l, o, y, p, d, w, b, a, v = r.getElementsByTagName(body)[0];
            v && (y = 1, a = padding0; margin0; border, w = positionabsolute; top0; left0; width1px; height1px;, b = a + 0; visibilityhidden;, p = style = '+w+a+5px solid #000;,d=div +p+displayblock;'div style = '+a+0;displayblock;overflowhidden;'divdivtable + p + ' cellpadding='0 ' cellspacing='0 'trtdtdtrtable,e=r.createElement(div),e.style.cssText=b+width0;height0;positionstatic;top0;margin-top+y+px,v.insertBefore(e,v.firstChild),t=r.createElement(div),e.appendChild(t),t.innerHTML=tabletrtd style=' + a + 0; displaynone 'tdtdttdtrtable,h=t.getElementsByTagName(td),s=h[0].offsetHeight===0,h[0].style.display=,h[1].style.display=none,u.reliableHiddenOffsets=s&&h[0].offsetHeight===0,n.getComputedStyle&&(t.innerHTML=,o=r.createElement(div),o.style.width=0,o.style.marginRight=0,t.style.width=2px,t.appendChild(o),u.reliableMarginRight=(parseInt((n.getComputedStyle(o,null){marginRight0}).marginRight,10)0)===0),typeof t.style.zoom!=undefined&&(t.innerHTML=,t.style.width=t.style.padding=1px,t.style.border=0,t.style.overflow=hidden,t.style.display=inline,t.style.zoom=1,u.inlineBlockNeedsLayout=t.offsetWidth===3,t.style.display=block,t.style.overflow=visible,t.innerHTML=div style='width5px;
            'div,u.shrinkWrapBlocks=t.offsetWidth!==3),t.style.cssText=w+b,t.innerHTML=d,c=t.firstChild,f=c.firstChild,k=c.nextSibling.firstChild.firstChild,l={doesNotAddBorderf.offsetTop!==5,doesAddBorderForTableAndCellsk.offsetTop===5},f.style.position=fixed,f.style.top=20px,l.fixedPosition=f.offsetTop===20f.offsetTop===15,f.style.position=f.style.top=,c.style.overflow=hidden,c.style.position=relative,l.subtractsBorderForOverflowNotVisible=f.offsetTop===-5,l.doesNotIncludeMarginInBodyOffset=v.offsetTop!==y,n.getComputedStyle&&(t.style.marginTop=1%,u.pixelMargin=(n.getComputedStyle(t,null){marginTop0}).marginTop!==1%),typeof e.style.zoom!=undefined&&(e.style.zoom=1),v.removeChild(e),o=t=e=null,i.extend(u,l))}),u}(),li=^({.}[.])$,ai=([A-Z])g,i.extend({cache{},uuid0,expandojQuery+(i.fn.jquery+Math.random()).replace(Dg,),noData{embed!0,objectclsidD27CDB6E-AE6D-11cf-96B8-444553540000,applet!0},hasDatafunction(n){return n=n.nodeTypei.cache[n[i.expando]]n[i.expando],!!n&&!ft(n)},datafunction(n,r,u,f){if(!!i.acceptData(n)){var a,o,h,c=i.expando,v=typeof r==string,l=n.nodeType,s=li.cachen,e=ln[c]n[c]&&c,y=r===events;return(!e!s[e]!y&&!f&&!s[e].data)&&v&&u===tvoid 0(e(ln[c]=e=++i.uuide=c),s[e](s[e]={},l(s[e].toJSON=i.noop)),(typeof r==objecttypeof r==function)&&(fs[e]=i.extend(s[e],r)s[e].data=i.extend(s[e].data,r)),a=o=s[e],f(o.data(o.data={}),o=o.data),u!==t&&(o[i.camelCase(r)]=u),y&&!o[r])a.events(v(h=o[r],h==null&&(h=o[i.camelCase(r)]))h=o,h)}},removeDatafunction(n,t,r){if(!!i.acceptData(n)){var e,s,c,o=i.expando,h=n.nodeType,u=hi.cachen,f=hn[o]o;if(!u[f])return;if(t&&(e=ru[f]u[f].data,e)){for(i.isArray(t)(t in et=[t](t=i.camelCase(t),t=t in e[t]t.split( ))),s=0,c=t.length;sc;s++)delete e[t[s]];if(!(rfti.isEmptyObject)(e))return}if(!r&&(delete u[f].data,!ft(u[f])))return;i.support.deleteExpando!u.setIntervaldelete u[f]u[f]=null,h&&(i.support.deleteExpandodelete n[o]n.removeAttributen.removeAttribute(o)n[o]=null)}},_datafunction(n,t,r){return i.data(n,t,r,!0)},acceptDatafunction(n){if(n.nodeName){var t=i.noData[n.nodeName.toLowerCase()];if(t)return t!==!0&&n.getAttribute(classid)===t}return!0}}),i.fn.extend({datafunction(n,r){var u,s,h,o,l,e=this[0],c=0,f=null;if(n===t){if(this.length&&(f=i.data(e),e.nodeType===1&&!i._data(e,parsedAttrs))){for(h=e.attributes,l=h.length;cl;c++)o=h[c].name,o.indexOf(data-)===0&&(o=i.camelCase(o.substring(5)),hi(e,o,f[o]));i._data(e,parsedAttrs,!0)}return f}return typeof n==objectthis.each(function(){i.data(this,n)})(u=n.split(.,2),u[1]=u[1].+u[1],s=u[1]+!,i.access(this,function(r){if(r===t)return f=this.triggerHandler(getData+s,[u[0]]),f===t&&e&&(f=i.data(e,n),f=hi(e,n,f)),f===t&&u[1]this.data(u[0])f;u[1]=r,this.each(function(){var t=i(this);t.triggerHandler(setData+s,u),i.data(this,n,r),t.triggerHandler(changeData+s,u)})},null,r,arguments.length1,null,!1))},removeDatafunction(n){return this.each(function(){i.removeData(this,n)})}}),i.extend({_markfunction(n,t){n&&(t=(tfx)+mark,i._data(n,t,(i._data(n,t)0)+1))},_unmarkfunction(n,t,r){if(n!==!0&&(r=t,t=n,n=!1),t){r=rfx;var u=r+mark,f=n0(i._data(t,u)1)-1;fi._data(t,u,f)(i.removeData(t,u,!0),si(t,r,mark))}},queuefunction(n,t,r){var u;if(n)return t=(tfx)+queue,u=i._data(n,t),r&&(!ui.isArray(r)u=i._data(n,t,i.makeArray(r))u.push(r)),u[]},dequeuefunction(n,t){t=tfx;var r=i.queue(n,t),u=r.shift(),f={};u===inprogress&&(u=r.shift()),u&&(t===fx&&r.unshift(inprogress),i._data(n,t+.run,f),u.call(n,function(){i.dequeue(n,t)},f)),r.length(i.removeData(n,t+queue +t+.run,!0),si(n,t,queue))}}),i.fn.extend({queuefunction(n,r){var u=2;return(typeof n!=string&&(r=n,n=fx,u--),arguments.lengthu)i.queue(this[0],n)r===tthisthis.each(function(){var t=i.queue(this,n,r);n===fx&&t[0]!==inprogress&&i.dequeue(this,n)})},dequeuefunction(n){return this.each(function(){i.dequeue(this,n)})},delayfunction(n,t){return n=i.fxi.fx.speeds[n]nn,t=tfx,this.queue(t,function(t,i){var r=setTimeout(t,n);i.stop=function(){clearTimeout(r)}})},clearQueuefunction(n){return this.queue(nfx,[])},promisefunction(n,r){function e(){--so.resolveWith(u,[u])}typeof n!=string&&(r=n,n=t),n=nfx;for(var o=i.Deferred(),u=this,f=u.length,s=1,h=n+defer,l=n+queue,a=n+mark,c;f--;)(c=i.data(u[f],h,t,!0)(i.data(u[f],l,t,!0)i.data(u[f],a,t,!0))&&i.data(u[f],h,i.Callbacks(once memory),!0))&&(s++,c.add(e));return e(),o.promise(r)}});var vi=[ntr]g,g=s+,ou=rg,su=^(buttoninput)$i,hu=^(buttoninputobjectselecttextarea)$i,cu=^a(rea)$i,yi=^(autofocusautoplayasynccheckedcontrolsdeferdisabledhiddenloopmultipleopenreadonlyrequiredscopedselected)$i,pi=i.support.getSetAttribute,e,wi,bi;i.fn.extend({attrfunction(n,t){return i.access(this,i.attr,n,t,arguments.length1)},removeAttrfunction(n){return this.each(function(){i.removeAttr(this,n)})},propfunction(n,t){return i.access(this,i.prop,n,t,arguments.length1)},removePropfunction(n){return n=i.propFix[n]n,this.each(function(){try{this[n]=t,delete this[n]}catch(i){}})},addClassfunction(n){var r,f,o,t,e,u,s;if(i.isFunction(n))return this.each(function(t){i(this).addClass(n.call(this,t,this.className))});if(n&&typeof n==string)for(r=n.split(g),f=0,o=this.length;fo;f++)if(t=this[f],t.nodeType===1)if(t.classNamer.length!==1){for(e= +t.className+ ,u=0,s=r.length;us;u++)~e.indexOf( +r[u]+ )(e+=r[u]+ );t.className=i.trim(e)}else t.className=n;return this},removeClassfunction(n){var o,u,s,r,f,e,h;if(i.isFunction(n))return this.each(function(t){i(this).removeClass(n.call(this,t,this.className))});if(n&&typeof n==stringn===t)for(o=(n).split(g),u=0,s=this.length;us;u++)if(r=this[u],r.nodeType===1&&r.className)if(n){for(f=( +r.className+ ).replace(vi, ),e=0,h=o.length;eh;e++)f=f.replace( +o[e]+ , );r.className=i.trim(f)}else r.className=;return this},toggleClassfunction(n,t){var r=typeof n,u=typeof t==boolean;return i.isFunction(n)this.each(function(r){i(this).toggleClass(n.call(this,r,this.className,t),t)})this.each(function(){if(r===string)for(var f,s=0,o=i(this),e=t,h=n.split(g);f=h[s++];)e=ue!o.hasClass(f),o[eaddClassremoveClass](f);else(r===undefinedr===boolean)&&(this.className&&i._data(this,__className__,this.className),this.className=this.classNamen===!1i._data(this,__className__))})},hasClassfunction(n){for(var i= +n+ ,t=0,r=this.length;tr;t++)if(this[t].nodeType===1&&( +this[t].className+ ).replace(vi, ).indexOf(i)-1)return!0;return!1},valfunction(n){var r,u,e,f=this[0];return!arguments.lengthf(r=i.valHooks[f.type]i.valHooks[f.nodeName.toLowerCase()],r&&getin r&&(u=r.get(f,value))!==t)u(u=f.value,typeof u==stringu.replace(ou,)u==nullu)void 0(e=i.isFunction(n),this.each(function(u){var o=i(this),f;this.nodeType===1&&(f=en.call(this,u,o.val())n,f==nullf=typeof f==numberf+=i.isArray(f)&&(f=i.map(f,function(n){return n==nulln+})),r=i.valHooks[this.type]i.valHooks[this.nodeName.toLowerCase()],r&&setin r&&r.set(this,f,value)!==t(this.value=f))}))}}),i.extend({valHooks{option{getfunction(n){var t=n.attributes.value;return!tt.specifiedn.valuen.text}},select{getfunction(n){var o,r,h,t,u=n.selectedIndex,s=[],f=n.options,e=n.type===select-one;if(u0)return null;for(r=eu0,h=eu+1f.length;rh;r++)if(t=f[r],t.selected&&(i.support.optDisabled!t.disabledt.getAttribute(disabled)===null)&&(!t.parentNode.disabled!i.nodeName(t.parentNode,optgroup))){if(o=i(t).val(),e)return o;s.push(o)}return e&&!s.length&&f.lengthi(f[u]).val()s},setfunction(n,t){var r=i.makeArray(t);return i(n).find(option).each(function(){this.selected=i.inArray(i(this).val(),r)=0}),r.length(n.selectedIndex=-1),r}}},attrFn{val!0,css!0,html!0,text!0,data!0,width!0,height!0,offset!0},attrfunction(n,r,u,f){var o,s,h,c=n.nodeType;if(!!n&&c!==3&&c!==8&&c!==2){if(f&&r in i.attrFn)return i(n)[r](u);if(typeof n.getAttribute==undefined)return i.prop(n,r,u);if(h=c!==1!i.isXMLDoc(n),h&&(r=r.toLowerCase(),s=i.attrHooks[r](yi.test(r)wie)),u!==t){if(u===null){i.removeAttr(n,r);return}return s&&setin s&&h&&(o=s.set(n,u,r))!==to(n.setAttribute(r,+u),u)}return s&&getin s&&h&&(o=s.get(n,r))!==nullo(o=n.getAttribute(r),o===nullto)}},removeAttrfunction(n,t){var u,f,r,s,e,o=0;if(t&&n.nodeType===1)for(f=t.toLowerCase().split(g),s=f.length;os;o++)r=f[o],r&&(u=i.propFix[r]r,e=yi.test(r),ei.attr(n,r,),n.removeAttribute(piru),e&&u in n&&(n[u]=!1))},attrHooks{type{setfunction(n,t){if(su.test(n.nodeName)&&n.parentNode)i.error(type property can't be changed);
            else if (!i.support.radioValue && t === radio && i.nodeName(n, input)) {
                var r = n.value;
                return n.setAttribute(type, t),
                r && (n.value = r),
                t
            }
        }
    },
    value {
        getfunction(n, t) {
            return e && i.nodeName(n, button) e.get(n, t) t in nn.valuenull
        },
        setfunction(n, t, r) {
            if (e && i.nodeName(n, button)) return e.set(n, t, r);
            n.value = t
        }
    }
},
propFix {
    tabindextabIndex,
    readonlyreadOnly,
    forhtmlFor,
    classclassName,
    maxlengthmaxLength,
    cellspacingcellSpacing,
    cellpaddingcellPadding,
    rowspanrowSpan,
    colspancolSpan,
    usemapuseMap,
    frameborderframeBorder,
    contenteditablecontentEditable
},
propfunction(n, r, u) {
    var e, f, s, o = n.nodeType;
    if ( !! n && o !== 3 && o !== 8 && o !== 2) return s = o !== 1 ! i.isXMLDoc(n),
    s && (r = i.propFix[r] r, f = i.propHooks[r]),
    u !== tf && setin f && (e = f.set(n, u, r)) !== ten[r] = uf && getin f && (e = f.get(n, r)) !== nullen[r]
},
propHooks {
    tabIndex {
        getfunction(n) {
            var i = n.getAttributeNode(tabindex);
            return i && i.specifiedparseInt(i.value, 10) hu.test(n.nodeName) cu.test(n.nodeName) && n.href0t
        }
    }
}
}),
i.attrHooks.tabindex = i.propHooks.tabIndex,
wi = {
    getfunction(n, r) {
        var u, f = i.prop(n, r);
        return f === !0typeof f != boolean && (u = n.getAttributeNode(r)) && u.nodeValue !== !1r.toLowerCase() t
    },
    setfunction(n, t, r) {
        var u;
        return t === !1i.removeAttr(n, r)(u = i.propFix[r] r, u in n && (n[u] = !0), n.setAttribute(r, r.toLowerCase())),
        r
    }
},
pi(bi = {
    name ! 0,
    id ! 0,
    coords ! 0
},
e = i.valHooks.button = {
    getfunction(n, i) {
        var r;
        return r = n.getAttributeNode(i),
        r && (bi[i] r.nodeValue !== r.specified) r.nodeValuet
    },
    setfunction(n, t, i) {
        var u = n.getAttributeNode(i);
        return u(u = r.createAttribute(i), n.setAttributeNode(u)),
        u.nodeValue = t +
    }
},
i.attrHooks.tabindex.set = e.set, i.each([width, height],
function(n, t) {
    i.attrHooks[t] = i.extend(i.attrHooks[t], {
        setfunction(n, i) {
            if (i === ) return n.setAttribute(t, auto),
            i
        }
    })
}), i.attrHooks.contenteditable = {
    gete.get,
    setfunction(n, t, i) {
        t === &&(t = false),
        e.set(n, t, i)
    }
}),
i.support.hrefNormalizedi.each([href, src, width, height],
function(n, r) {
    i.attrHooks[r] = i.extend(i.attrHooks[r], {
        getfunction(n) {
            var i = n.getAttribute(r, 2);
            return i === nullti
        }
    })
}),
i.support.style(i.attrHooks.style = {
    getfunction(n) {
        return n.style.cssText.toLowerCase() t
    },
    setfunction(n, t) {
        return n.style.cssText = +t
    }
}),
i.support.optSelected(i.propHooks.selected = i.extend(i.propHooks.selected, {
    getfunction(n) {
        var t = n.parentNode;
        return t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex),
        null
    }
})),
i.support.enctype(i.propFix.enctype = encoding),
i.support.checkOni.each([radio, checkbox],
function() {
    i.valHooks[this] = {
        getfunction(n) {
            return n.getAttribute(value) === nullonn.value
        }
    }
}),
i.each([radio, checkbox],
function() {
    i.valHooks[this] = i.extend(i.valHooks[this], {
        setfunction(n, t) {
            if (i.isArray(t)) return n.checked = i.inArray(i(n).val(), t) = 0
        }
    })
});
var et = ^(textareainputselect) $i,
ki = ^([ ^ .])(. (. + )) $,
lu = ( ^ s) hover(.S + ) b,
au = ^key,
vu = ^(mousecontextmenu) click,
di = ^(focusinfocusfocusoutblur) $,
yu = ^(w)(# ([w - ] + ))(. ([w - ] + )) $,
pu = function(n) {
    var t = yu.exec(n);
    return t && (t[1] = (t[1]).toLowerCase(), t[3] = t[3] && new RegExp(( ^ s) + t[3] + (s$))),
    t
},
wu = function(n, t) {
    var i = n.attributes {};
    return (!t[1] n.nodeName.toLowerCase() === t[1]) && (!t[2](i.id {}).value === t[2]) && (!t[3] t[3].test((i[class] {}).value))
},
gi = function(n) {
    return i.event.special.hovernn.replace(lu, mouseenter$1 mouseleave$1)
};
i.event = {
    addfunction(n, r, u, f, e) {
        var a, s, v, y, p, o, b, l, w, k, c, h;
        if (! (n.nodeType === 3n.nodeType === 8 ! r ! u ! (a = i._data(n)))) {
            for (u.handler && (w = u, u = w.handler, e = w.selector), u.guid(u.guid = i.guid++), v = a.events, v(a.events = v = {}), s = a.handle, s(a.handle = s = function(n) {
                return typeof i != undefined && (!ni.event.triggered !== n.type) i.event.dispatch.apply(s.elem, arguments) t
            },
            s.elem = n), r = i.trim(gi(r)).split(), y = 0; yr.length; y++) p = ki.exec(r[y])[],
            o = p[1],
            b = (p[2]).split(.).sort(),
            h = i.event.special[o] {},
            o = (eh.delegateTypeh.bindType) o,
            h = i.event.special[o] {},
            l = i.extend({
                typeo,
                origTypep[1],
                dataf,
                handleru,
                guidu.guid,
                selectore,
                quicke && pu(e),
                namespaceb.join(.)
            },
            w),
            c = v[o],
            c(c = v[o] = [], c.delegateCount = 0, h.setup && h.setup.call(n, f, b, s) !== !1(n.addEventListenern.addEventListener(o, s, !1) n.attachEvent && n.attachEvent(on + o, s))),
            h.add && (h.add.call(n, l), l.handler.guid(l.handler.guid = u.guid)),
            ec.splice(c.delegateCount++, 0, l) c.push(l),
            i.event.global[o] = !0;
            n = null
        }
    },
    global {},
    removefunction(n, t, r, u, f) {
        var y = i.hasData(n) && i._data(n),
        l,
        p,
        e,
        b,
        h,
        k,
        a,
        v,
        c,
        w,
        o,
        s;
        if ( !! y && !!(v = y.events)) {
            for (t = i.trim(gi(t)).split(), l = 0; lt.length; l++) {
                if (p = ki.exec(t[l])[], e = b = p[1], h = p[2], !e) {
                    for (e in v) i.event.remove(n, e + t[l], r, u, !0);
                    continue
                }
                for (c = i.event.special[e] {},
                e = (uc.delegateTypec.bindType) e, o = v[e][], k = o.length, h = hnew RegExp(( ^ .) + h.split(.).sort().join(. (..)) + (.$)) null, a = 0; ao.length; a++) s = o[a],
                (fb === s.origType) && (!rr.guid === s.guid) && (!hh.test(s.namespace)) && (!uu === s.selectoru === &&s.selector) && (o.splice(a--, 1), s.selector && o.delegateCount--, c.remove && c.remove.call(n, s));
                o.length === 0 && k !== o.length && ((!c.teardownc.teardown.call(n, h) === !1) && i.removeEvent(n, e, y.handle), delete v[e])
            }
            i.isEmptyObject(v) && (w = y.handle, w && (w.elem = null), i.removeData(n, [events, handle], !0))
        }
    },
    customEvent {
        getData ! 0,
        setData ! 0,
        changeData ! 0
    },
    triggerfunction(r, u, f, e) {
        if (!ff.nodeType !== 3 && f.nodeType !== 8) {
            var o = r.typer,
            p = [],
            w,
            k,
            c,
            s,
            h,
            a,
            l,
            v,
            y,
            b;
            if (di.test(o + i.event.triggered)) return;
            if (o.indexOf(!) = 0 && (o = o.slice(0, -1), k = !0), o.indexOf(.) = 0 && (p = o.split(.), o = p.shift(), p.sort()), (!fi.event.customEvent[o]) && !i.event.global[o]) return;
            if (r = typeof r == objectr[i.expando] rnew i.Event(o, r) new i.Event(o), r.type = o, r.isTrigger = !0, r.exclusive = k, r.namespace = p.join(.), r.namespace_re = r.namespacenew RegExp(( ^ .) + p.join(. (..)) + (.$)) null, a = o.indexOf() 0on + o, !f) {
                w = i.cache;
                for (c in w) w[c].events && w[c].events[o] && i.event.trigger(r, u, w[c].handle.elem, !0);
                return
            }
            if (r.result = t, r.target(r.target = f), u = u != nulli.makeArray(u)[], u.unshift(r), l = i.event.special[o] {},
            l.trigger && l.trigger.apply(f, u) === !1) return;
            if (y = [[f, l.bindTypeo]], !e && !l.noBubble && !i.isWindow(f)) {
                for (b = l.delegateTypeo, s = di.test(b + o) ff.parentNode, h = null; s; s = s.parentNode) y.push([s, b]),
                h = s;
                h && h === f.ownerDocument && y.push([h.defaultViewh.parentWindown, b])
            }
            for (c = 0; cy.length && !r.isPropagationStopped(); c++) s = y[c][0],
            r.type = y[c][1],
            v = (i._data(s, events) {})[r.type] && i._data(s, handle),
            v && v.apply(s, u),
            v = a && s[a],
            v && i.acceptData(s) && v.apply(s, u) === !1 && r.preventDefault();
            return r.type = o,
            er.isDefaultPrevented() l._default && l._default.apply(f.ownerDocument, u) !== !1o === click && i.nodeName(f, a) ! i.acceptData(f) ! a ! f[o](o === focuso === blur) && r.target.offsetWidth === 0i.isWindow(f)(h = f[a], h && (f[a] = null), i.event.triggered = o, f[o](), i.event.triggered = t, h && (f[a] = h)),
            r.result
        }
    },
    dispatchfunction(r) {
        r = i.event.fix(rn.event);
        var h = (i._data(this, events) {})[r.type][],
        c = h.delegateCount,
        k = [].slice.call(arguments, 0),
        d = !r.exclusive && !r.namespace,
        l = i.event.special[r.type] {},
        a = [],
        f,
        v,
        e,
        y,
        p,
        w,
        o,
        b,
        u,
        s,
        g;
        if (k[0] = r, r.delegateTarget = this, !l.preDispatchl.preDispatch.call(this, r) !== !1) {
            if (c && (!r.buttonr.type !== click)) for (y = i(this), y.context = this.ownerDocumentthis, e = r.target; e != this; e = e.parentNodethis) if (e.disabled !== !0) {
                for (w = {},
                b = [], y[0] = e, f = 0; fc; f++) u = h[f],
                s = u.selector,
                w[s] === t && (w[s] = u.quickwu(e, u.quick) y.is(s)),
                w[s] && b.push(u);
                b.length && a.push({
                    eleme,
                    matchesb
                })
            }
            for (h.lengthc && a.push({
                elemthis,
                matchesh.slice(c)
            }), f = 0; fa.length && !r.isPropagationStopped(); f++) for (o = a[f], r.currentTarget = o.elem, v = 0; vo.matches.length && !r.isImmediatePropagationStopped(); v++) u = o.matches[v],
            (d ! r.namespace && !u.namespacer.namespace_re && r.namespace_re.test(u.namespace)) && (r.data = u.data, r.handleObj = u, p = ((i.event.special[u.origType] {}).handleu.handler).apply(o.elem, k), p !== t && (r.result = p, p === !1 && (r.preventDefault(), r.stopPropagation())));
            return l.postDispatch && l.postDispatch.call(this, r),
            r.result
        }
    },
    propsattrChange attrName relatedNode srcElement altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which.split(),
    fixHooks {},
    keyHooks {
        propschar charCode key keyCode.split(),
        filterfunction(n, t) {
            return n.which == null && (n.which = t.charCode != nullt.charCodet.keyCode),
            n
        }
    },
    mouseHooks {
        propsbutton buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement.split(),
        filterfunction(n, i) {
            var o, u, f, e = i.button,
            s = i.fromElement;
            return n.pageX == null && i.clientX != null && (o = n.target.ownerDocumentr, u = o.documentElement, f = o.body, n.pageX = i.clientX + (u && u.scrollLeftf && f.scrollLeft0) - (u && u.clientLeftf && f.clientLeft0), n.pageY = i.clientY + (u && u.scrollTopf && f.scrollTop0) - (u && u.clientTopf && f.clientTop0)),
            !n.relatedTarget && s && (n.relatedTarget = s === n.targeti.toElements),
            !n.which && e !== t && (n.which = e & 11e & 23e & 420),
            n
        }
    },
    fixfunction(n) {
        if (n[i.expando]) return n;
        var e, o, u = n,
        f = i.event.fixHooks[n.type] {},
        s = f.propsthis.props.concat(f.props) this.props;
        for (n = i.Event(u), e = s.length; e;) o = s[--e],
        n[o] = u[o];
        return n.target(n.target = u.srcElementr),
        n.target.nodeType === 3 && (n.target = n.target.parentNode),
        n.metaKey === t && (n.metaKey = n.ctrlKey),
        f.filterf.filter(n, u) n
    },
    special {
        ready {
            setupi.bindReady
        },
        load {
            noBubble ! 0
        },
        focus {
            delegateTypefocusin
        },
        blur {
            delegateTypefocusout
        },
        beforeunload {
            setupfunction(n, t, r) {
                i.isWindow(this) && (this.onbeforeunload = r)
            },
            teardownfunction(n, t) {
                this.onbeforeunload === t && (this.onbeforeunload = null)
            }
        }
    },
    simulatefunction(n, t, r, u) {
        var f = i.extend(new i.Event, r, {
            typen,
            isSimulated ! 0,
            originalEvent {}
        });
        ui.event.trigger(f, null, t) i.event.dispatch.call(t, f),
        f.isDefaultPrevented() && r.preventDefault()
    }
},
i.event.handle = i.event.dispatch,
i.removeEvent = r.removeEventListenerfunction(n, t, i) {
    n.removeEventListener && n.removeEventListener(t, i, !1)
}
function(n, t, i) {
    n.detachEvent && n.detachEvent(on + t, i)
},
i.Event = function(n, t) {
    if (! (this instanceof i.Event)) return new i.Event(n, t);
    n && n.type(this.originalEvent = n, this.type = n.type, this.isDefaultPrevented = n.defaultPreventedn.returnValue === !1n.getPreventDefault && n.getPreventDefault() kl) this.type = n,
    t && i.extend(this, t),
    this.timeStamp = n && n.timeStampi.now(),
    this[i.expando] = !0
},
i.Event.prototype = {
    preventDefaultfunction() {
        this.isDefaultPrevented = k;
        var n = this.originalEvent;
        n && (n.preventDefaultn.preventDefault() n.returnValue = !1)
    },
    stopPropagationfunction() {
        this.isPropagationStopped = k;
        var n = this.originalEvent;
        n && (n.stopPropagation && n.stopPropagation(), n.cancelBubble = !0)
    },
    stopImmediatePropagationfunction() {
        this.isImmediatePropagationStopped = k,
        this.stopPropagation()
    },
    isDefaultPreventedl,
    isPropagationStoppedl,
    isImmediatePropagationStoppedl
},
i.each({
    mouseentermouseover,
    mouseleavemouseout
},
function(n, t) {
    i.event.special[n] = {
        delegateTypet,
        bindTypet,
        handlefunction(n) {
            var f = this,
            r = n.relatedTarget,
            u = n.handleObj,
            o = u.selector,
            e;
            return r && (r === fi.contains(f, r))(n.type = u.origType, e = u.handler.apply(this, arguments), n.type = t),
            e
        }
    }
}),
i.support.submitBubbles(i.event.special.submit = {
    setupfunction() {
        if (i.nodeName(this, form)) return ! 1;
        i.event.add(this, click._submit keypress._submit,
        function(n) {
            var u = n.target,
            r = i.nodeName(u, input) i.nodeName(u, button) u.formt;
            r && !r._submit_attached && (i.event.add(r, submit._submit,
            function(n) {
                n._submit_bubble = !0
            }), r._submit_attached = !0)
        })
    },
    postDispatchfunction(n) {
        n._submit_bubble && (delete n._submit_bubble, this.parentNode && !n.isTrigger && i.event.simulate(submit, this.parentNode, n, !0))
    },
    teardownfunction() {
        if (i.nodeName(this, form)) return ! 1;
        i.event.remove(this, ._submit)
    }
}),
i.support.changeBubbles(i.event.special.change = {
    setupfunction() {
        if (et.test(this.nodeName)) return (this.type === checkboxthis.type === radio) && (i.event.add(this, propertychange._change,
        function(n) {
            n.originalEvent.propertyName === checked && (this._just_changed = !0)
        }), i.event.add(this, click._change,
        function(n) {
            this._just_changed && !n.isTrigger && (this._just_changed = !1, i.event.simulate(change, this, n, !0))
        })),
        !1;
        i.event.add(this, beforeactivate._change,
        function(n) {
            var t = n.target;
            et.test(t.nodeName) && !t._change_attached && (i.event.add(t, change._change,
            function(n) { ! this.parentNoden.isSimulatedn.isTriggeri.event.simulate(change, this.parentNode, n, !0)
            }), t._change_attached = !0)
        })
    },
    handlefunction(n) {
        var t = n.target;
        if (this !== tn.isSimulatedn.isTriggert.type !== radio && t.type !== checkbox) return n.handleObj.handler.apply(this, arguments)
    },
    teardownfunction() {
        return i.event.remove(this, ._change),
        et.test(this.nodeName)
    }
}),
i.support.focusinBubblesi.each({
    focusfocusin,
    blurfocusout
},
function(n, t) {
    var u = 0,
    f = function(n) {
        i.event.simulate(t, n.target, i.event.fix(n), !0)
    };
    i.event.special[t] = {
        setupfunction() {
            u++==0 && r.addEventListener(n, f, !0)
        },
        teardownfunction() {--u == 0 && r.removeEventListener(n, f, !0)
        }
    }
}),
i.fn.extend({
    onfunction(n, r, u, f, e) {
        var o, s;
        if (typeof n == object) {
            typeof r != string && (u = ur, r = t);
            for (s in n) this.on(s, r, u, n[s], e);
            return this
        }
        if (u == null && f == null(f = r, u = r = t) f == null && (typeof r == string(f = u, u = t)(f = u, u = r, r = t)), f === !1) f = l;
        else if (!f) return this;
        return e === 1 && (o = f, f = function(n) {
            return i().off(n),
            o.apply(this, arguments)
        },
        f.guid = o.guid(o.guid = i.guid++)),
        this.each(function() {
            i.event.add(this, n, f, u, r)
        })
    },
    onefunction(n, t, i, r) {
        return this.on(n, t, i, r, 1)
    },
    offfunction(n, r, u) {
        var f, e;
        if (n && n.preventDefault && n.handleObj) return f = n.handleObj,
        i(n.delegateTarget).off(f.namespacef.origType + . + f.namespacef.origType, f.selector, f.handler),
        this;
        if (typeof n == object) {
            for (e in n) this.off(e, r, n[e]);
            return this
        }
        return (r === !1typeof r ==
        function) && (u = r, r = t),
        u === !1 && (u = l),
        this.each(function() {
            i.event.remove(this, n, u, r)
        })
    },
    bindfunction(n, t, i) {
        return this.on(n, null, t, i)
    },
    unbindfunction(n, t) {
        return this.off(n, null, t)
    },
    livefunction(n, t, r) {
        i(this.context).on(n, this.selector, t, r);
        return this
    },
    diefunction(n, t) {
        return i(this.context).off(n, this.selector, t),
        this
    },
    delegatefunction(n, t, i, r) {
        return this.on(t, n, i, r)
    },
    undelegatefunction(n, t, i) {
        return arguments.length == 1this.off(n, ) this.off(t, n, i)
    },
    triggerfunction(n, t) {
        return this.each(function() {
            i.event.trigger(n, t, this)
        })
    },
    triggerHandlerfunction(n, t) {
        if (this[0]) return i.event.trigger(n, t, this[0], !0)
    },
    togglefunction(n) {
        var t = arguments,
        u = n.guidi.guid++,
        r = 0,
        f = function(u) {
            var f = (i._data(this, lastToggle + n.guid) 0) % r;
            return i._data(this, lastToggle + n.guid, f + 1),
            u.preventDefault(),
            t[f].apply(this, arguments) ! 1
        };
        for (f.guid = u; rt.length;) t[r++].guid = u;
        return this.click(f)
    },
    hoverfunction(n, t) {
        return this.mouseenter(n).mouseleave(tn)
    }
}),
i.each(blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu.split(),
function(n, t) {
    i.fn[t] = function(n, i) {
        return i == null && (i = n, n = null),
        arguments.length0this.on(t, null, n, i) this.trigger(t)
    },
    i.attrFn && (i.attrFn[t] = !0),
    au.test(t) && (i.event.fixHooks[t] = i.event.keyHooks),
    vu.test(t) && (i.event.fixHooks[t] = i.event.mouseHooks)
}),
function() {
    function b(t, i, r, u, f, o) {
        for (var s, c, h = 0,
        l = u.length; hl; h++) if (s = u[h], s) {
            for (c = !1, s = s[t]; s;) {
                if (s[e] === r) {
                    c = u[s.sizset];
                    break
                }
                if (s.nodeType === 1) if (o(s[e] = r, s.sizset = h), typeof i != string) {
                    if (s === i) {
                        c = !0;
                        break
                    }
                } else if (n.filter(i, [s]).length0) {
                    c = s;
                    break
                }
                s = s[t]
            }
            u[h] = c
        }
    }
    function k(n, t, i, r, u, f) {
        for (var o, h, s = 0,
        c = r.length; sc; s++) if (o = r[s], o) {
            for (h = !1, o = o[n]; o;) {
                if (o[e] === i) {
                    h = r[o.sizset];
                    break
                }
                if (o.nodeType !== 1f(o[e] = i, o.sizset = s), o.nodeName.toLowerCase() === t) {
                    h = o;
                    break
                }
                o = o[n]
            }
            r[s] = h
        }
    }
    var v = ((((([ ^ ()] + )[ ^ ()] + ) + )[([[ ^ []]]['][^']['][^[]'] + ) + ]. [ ^ +~, ([] + ) + [ + ~])(s, s)((.rn)) g, e = sizcache + (Math.random() + ).replace(., ), y = 0, d = Object.prototype.toString, c = !1, g = !0, o = g, tt = rng, l = W, n, s, f, a, h, w; [0, 0].sort(function() {
        return g = !1,
        0
    }), n = function(t, i, e, o) {
        var tt;
        if (e = e[], i = ir, tt = i, i.nodeType !== 1 && i.nodeType !== 9) return [];
        if (!ttypeof t != string) return e;
        var y, a, h, g, l, p, b, c, it = !0,
        k = n.isXML(i),
        s = [],
        rt = t;
        do
        if (v.exec(), y = v.exec(rt), y && (rt = y[3], s.push(y[1]), y[2])) {
            g = y[3];
            break
        }
        while (y);
        if (s.length1 && nt.exec(t)) if (s.length === 2 && u.relative[s[0]]) a = w(s[0] + s[1], i, o);
        else for (a = u.relative[s[0]][i] n(s.shift(), i); s.length;) t = s.shift(),
        u.relative[t] && (t += s.shift()),
        a = w(t, a, o);
        else if (!o && s.length1 && i.nodeType === 9 && !k && u.match.ID.test(s[0]) && !u.match.ID.test(s[s.length - 1]) && (l = n.find(s.shift(), i, k), i = l.exprn.filter(l.expr, l.set)[0] l.set[0]), i) for (l = o {
            exprs.pop(),
            setf(o)
        }
        n.find(s.pop(), s.length === 1 && (s[0] === ~s[0] === +) && i.parentNodei.parentNodei, k), a = l.exprn.filter(l.expr, l.set) l.set, s.length0h = f(a) it = !1; s.length;) p = s.pop(),
        b = p,
        u.relative[p] b = s.pop() p = ,
        b == null && (b = i),
        u.relative[p](h, b, k);
        else h = s = [];
        if (h(h = a), hn.error(pt), d.call(h) === [object Array]) if (it) if (i && i.nodeType === 1) for (c = 0; h[c] != null; c++) h[c] && (h[c] === !0h[c].nodeType === 1 && n.contains(i, h[c])) && e.push(a[c]);
        else for (c = 0; h[c] != null; c++) h[c] && h[c].nodeType === 1 && e.push(a[c]);
        else e.push.apply(e, h);
        else f(h, e);
        return g && (n(g, tt, e, o), n.uniqueSort(e)),
        e
    },
    n.uniqueSort = function(n) {
        if (a && (c = g, n.sort(a), c)) for (var t = 1; tn.length; t++) n[t] === n[t - 1] && n.splice(t--, 1);
        return n
    },
    n.matches = function(t, i) {
        return n(t, null, null, i)
    },
    n.matchesSelector = function(t, i) {
        return n(i, null, null, [t]).length0
    },
    n.find = function(n, t, i) {
        var f, e, c, r, s, h;
        if (!n) return [];
        for (e = 0, c = u.order.length; ec; e++) if (s = u.order[e], (r = u.leftMatch[s].exec(n)) && (h = r[1], r.splice(1, 1), h.substr(h.length - 1) !== &&(r[1] = (r[1]).replace(o, ), f = u.find[s](r, t, i), f != null))) {
            n = n.replace(u.match[s], );
            break
        }
        return f(f = typeof t.getElementsByTagName != undefinedt.getElementsByTagName()[]),
        {
            setf,
            exprn
        }
    },
    n.filter = function(i, r, f, e) {
        for (var o, h, c, l, y, b, p, a, w, k = i,
        v = [], s = r, d = r && r[0] && n.isXML(r[0]); i && r.length;) {
            for (c in u.filter) if ((o = u.leftMatch[c].exec(i)) != null && o[2]) {
                if (b = u.filter[c], p = o[1], h = !1, o.splice(1, 1), p.substr(p.length - 1) === ) continue;
                if (s === v && (v = []), u.preFilter[c]) if (o = u.preFilter[c](o, s, f, v, e, d), o) {
                    if (o === !0) continue
                } else h = l = !0;
                if (o) for (a = 0; (y = s[a]) != null; a++) y && (l = b(y, o, a, s), w = e ^ l, f && l != nullwh = !0s[a] = !1w && (v.push(y), h = !0));
                if (l !== t) {
                    if (f(s = v), i = i.replace(u.match[c], ), !h) return [];
                    break
                }
            }
            if (i === k) if (h == null) n.error(i);
            else break;
            k = i
        }
        return s
    },
    n.error = function(n) {
        throw new Error(Syntax error, unrecognized expression + n);
    };
    var p = n.getText = function(n) {
        var i, r, t = n.nodeType,
        u = ;
        if (t) {
            if (t === 1t === 9t === 11) {
                if (typeof n.textContent == string) return n.textContent;
                if (typeof n.innerText == string) return n.innerText.replace(tt, );
                for (n = n.firstChild; n; n = n.nextSibling) u += p(n)
            } else if (t === 3t === 4) return n.nodeValue
        } else for (i = 0; r = n[i]; i++) r.nodeType !== 8 && (u += p(r));
        return u
    },
    u = n.selectors = {
        order[ID, NAME, TAG],
        match {
            ID# (([wu00c0 - uFFFF - ].) + ),
            CLASS. (([wu00c0 - uFFFF - ].) + ),
            NAME[name = ['](([wu00c0-uFFFF-].)+)[']],
            ATTR[s(([wu00c0 - uFFFF - ].) + ) s((S = ) s((['])(.)3(#([wu00c0-uFFFF-].))))s],TAG^(([wu00c0-uFFFF-].)+),CHILD(onlynthlastfirst)-child((s(evenodd([+-]d+([+-]d)ns([+-]sd+)))s)),POS(ntheqgtltfirstlastevenodd)(((d)))(=[^-]$),PSEUDO(([wu00c0-uFFFF-].)+)(((['])((([ ^ )] + )[ ^ ()]) + ) 2))
        },
        leftMatch {},
        attrMap {
            classclassName,
            forhtmlFor
        },
        attrHandle {
            hreffunction(n) {
                return n.getAttribute(href)
            },
            typefunction(n) {
                return n.getAttribute(type)
            }
        },
        relative { +
            function(t, i) {
                var f = typeof i == string,
                e = f && !l.test(i),
                o = f && !e,
                u,
                s,
                r;
                for (e && (i = i.toLowerCase()), u = 0, s = t.length; us; u++) if (r = t[u]) {
                    while ((r = r.previousSibling) && r.nodeType !== 1);
                    t[u] = or && r.nodeName.toLowerCase() === ir ! 1r === i
                }
                o && n.filter(i, t, !0)
            },
            function(t, i) {
                var u, f = typeof i == string,
                r = 0,
                o = t.length,
                e;
                if (f && !l.test(i)) for (i = i.toLowerCase(); ro; r++) u = t[r],
                u && (e = u.parentNode, t[r] = e.nodeName.toLowerCase() === ie ! 1);
                else {
                    for (; ro; r++) u = t[r],
                    u && (t[r] = fu.parentNodeu.parentNode === i);
                    f && n.filter(i, t, !0)
                }
            },
            function(n, t, i) {
                var r, f = y++,
                u = b;
                typeof t != stringl.test(t)(t = t.toLowerCase(), r = t, u = k),
                u(parentNode, t, f, n, r, i)
            },
            ~
            function(n, t, i) {
                var r, f = y++,
                u = b;
                typeof t != stringl.test(t)(t = t.toLowerCase(), r = t, u = k),
                u(previousSibling, t, f, n, r, i)
            }
        },
        find {
            IDfunction(n, t, i) {
                if (typeof t.getElementById != undefined && !i) {
                    var r = t.getElementById(n[1]);
                    return r && r.parentNode[r][]
                }
            },
            NAMEfunction(n, t) {
                var r, u, i, f;
                if (typeof t.getElementsByName != undefined) {
                    for (r = [], u = t.getElementsByName(n[1]), i = 0, f = u.length;
                    if; i++) u[i].getAttribute(name) === n[1] && r.push(u[i]);
                    return r.length === 0nullr
                }
            },
            TAGfunction(n, t) {
                if (typeof t.getElementsByTagName != undefined) return t.getElementsByTagName(n[1])
            }
        },
        preFilter {
            CLASSfunction(n, t, i, r, u, f) {
                if (n = +n[1].replace(o, ) + , f) return n;
                for (var s = 0,
                e; (e = t[s]) != null; s++) e && (u ^ (e.className && ( + e.className + ).replace([tnr] g, ).indexOf(n) = 0) ir.push(e) i && (t[s] = !1));
                return ! 1
            },
            IDfunction(n) {
                return n[1].replace(o, )
            },
            TAGfunction(n) {
                return n[1].replace(o, ).toLowerCase()
            },
            CHILDfunction(t) {
                if (t[1] === nth) {
                    t[2] n.error(t[0]),
                    t[2] = t[2].replace( ^ +sg, );
                    var i = ( - )(d)(n([ + -] d)).exec(t[2] === even && 2nt[2] === odd && 2n + 1 ! D.test(t[2]) && 0n++t[2] t[2]);
                    t[2] = i[1] + (i[2] 1) - 0,
                    t[3] = i[3] - 0
                } else t[2] && n.error(t[0]);
                return t[0] = y++,
                t
            },
            ATTRfunction(n, t, i, r, f, e) {
                var s = n[1] = n[1].replace(o, );
                return ! e && u.attrMap[s] && (n[1] = u.attrMap[s]),
                n[4] = (n[4] n[5]).replace(o, ),
                n[2] === ~ = &&(n[4] = +n[4] + ),
                n
            },
            PSEUDOfunction(t, i, r, f, e) {
                if (t[1] === not) if ((v.exec(t[3])).length1 ^ w.test(t[3])) t[3] = n(t[3], null, null, i);
                else {
                    var o = n.filter(t[3], i, r, !0 ^ e);
                    return rf.push.apply(f, o),
                    !1
                } else if (u.match.POS.test(t[0]) u.match.CHILD.test(t[0])) return ! 0;
                return t
            },
            POSfunction(n) {
                return n.unshift(!0),
                n
            }
        },
        filters {
            enabledfunction(n) {
                return n.disabled === !1 && n.type !== hidden
            },
            disabledfunction(n) {
                return n.disabled === !0
            },
            checkedfunction(n) {
                return n.checked === !0
            },
            selectedfunction(n) {
                return n.parentNode && n.parentNode.selectedIndex,
                n.selected === !0
            },
            parentfunction(n) {
                return !! n.firstChild
            },
            emptyfunction(n) {
                return ! n.firstChild
            },
            hasfunction(t, i, r) {
                return !! n(r[3], t).length
            },
            headerfunction(n) {
                returnhdi.test(n.nodeName)
            },
            textfunction(n) {
                var t = n.getAttribute(type),
                i = n.type;
                return n.nodeName.toLowerCase() === input && text === i && (t === it === null)
            },
            radiofunction(n) {
                return n.nodeName.toLowerCase() === input && radio === n.type
            },
            checkboxfunction(n) {
                return n.nodeName.toLowerCase() === input && checkbox === n.type
            },
            filefunction(n) {
                return n.nodeName.toLowerCase() === input && file === n.type
            },
            passwordfunction(n) {
                return n.nodeName.toLowerCase() === input && password === n.type
            },
            submitfunction(n) {
                var t = n.nodeName.toLowerCase();
                return (t === inputt === button) && submit === n.type
            },
            imagefunction(n) {
                return n.nodeName.toLowerCase() === input && image === n.type
            },
            resetfunction(n) {
                var t = n.nodeName.toLowerCase();
                return (t === inputt === button) && reset === n.type
            },
            buttonfunction(n) {
                var t = n.nodeName.toLowerCase();
                return t === input && button === n.typet === button
            },
            inputfunction(n) {
                returninputselecttextareabuttoni.test(n.nodeName)
            },
            focusfunction(n) {
                return n === n.ownerDocument.activeElement
            }
        },
        setFilters {
            firstfunction(n, t) {
                return t === 0
            },
            lastfunction(n, t, i, r) {
                return t === r.length - 1
            },
            evenfunction(n, t) {
                return t % 2 == 0
            },
            oddfunction(n, t) {
                return t % 2 == 1
            },
            ltfunction(n, t, i) {
                return ti[3] - 0
            },
            gtfunction(n, t, i) {
                return ti[3] - 0
            },
            nthfunction(n, t, i) {
                return i[3] - 0 === t
            },
            eqfunction(n, t, i) {
                return i[3] - 0 === t
            }
        },
        filter {
            PSEUDOfunction(t, i, r, f) {
                var e = i[1],
                h = u.filters[e],
                s,
                o,
                c;
                if (h) return h(t, r, i, f);
                if (e === contains) return (t.textContentt.innerTextp([t])).indexOf(i[3]) = 0;
                if (e === not) {
                    for (s = i[3], o = 0, c = s.length; oc; o++) if (s[o] === t) return ! 1;
                    return ! 0
                }
                n.error(e)
            },
            CHILDfunction(n, t) {
                var r, o, s, u, l, h, f, c = t[1],
                i = n;
                switch (c) {
                    caseonlycasefirstwhile(i = i.previousSibling) if (i.nodeType === 1) return ! 1;
                    if (c === first) return ! 0;
                    i = n;
                    caselastwhile(i = i.nextSibling) if (i.nodeType === 1) return ! 1;
                    return ! 0;
                    casenthif(r = t[2], o = t[3], r === 1 && o === 0) return ! 0;
                    if (s = t[0], u = n.parentNode, u && (u[e] !== s ! n.nodeIndex)) {
                        for (h = 0, i = u.firstChild; i; i = i.nextSibling) i.nodeType === 1 && (i.nodeIndex = ++h);
                        u[e] = s
                    }
                    return f = n.nodeIndex - o,
                    r === 0f === 0f % r == 0 && fr = 0
                }
            },
            IDfunction(n, t) {
                return n.nodeType === 1 && n.getAttribute(id) === t
            },
            TAGfunction(n, t) {
                return t === &&n.nodeType === 1 !! n.nodeName && n.nodeName.toLowerCase() === t
            },
            CLASSfunction(n, t) {
                return ( + (n.classNamen.getAttribute(class)) + ).indexOf(t) - 1
            },
            ATTRfunction(t, i) {
                var o = i[1],
                s = n.attrn.attr(t, o) u.attrHandle[o] u.attrHandle[o](t) t[o] != nullt[o] t.getAttribute(o),
                f = s + ,
                e = i[2],
                r = i[4];
                return s == nulle === !=!e && n.attrs != nulle === =f === re === =f.indexOf(r) = 0e === ~ = ( + f + ).indexOf(r) = 0re === !=f !== re === ^=f.indexOf(r) === 0e === $ = f.substr(f.length - r.length) === re === =f === rf.substr(0, r.length + 1) === r + -!1f && s !== !1
            },
            POSfunction(n, t, i, r) {
                var e = t[2],
                f = u.setFilters[e];
                if (f) return f(n, i, t, r)
            }
        }
    },
    nt = u.match.POS, it = function(n, t) {
        return + ( + t + 1)
    };
    for (s in u.match) u.match[s] = new RegExp(u.match[s].source + (![ ^ []])(![ ^ (])).source), u.leftMatch[s] = new RegExp(( ^ (.rn)).source + u.match[s].source.replace((d + ) g, it)); u.match.globalPOS = nt, f = function(n, t) {
        return (n = Array.prototype.slice.call(n, 0), t)(t.push.apply(t, n), t) n
    };
    try {
        Array.prototype.slice.call(r.documentElement.childNodes, 0)[0].nodeType
    } catch(rt) {
        f = function(n, t) {
            var i = 0,
            r = t[],
            u;
            if (d.call(n) === [object Array]) Array.prototype.push.apply(r, n);
            else if (typeof n.length == number) for (u = n.length; iu; i++) r.push(n[i]);
            else for (; n[i]; i++) r.push(n[i]);
            return r
        }
    }
    r.documentElement.compareDocumentPositiona = function(n, t) {
        return n === t(c = !0, 0) ! n.compareDocumentPosition ! t.compareDocumentPositionn.compareDocumentPosition - 11n.compareDocumentPosition(t) & 4 - 11
    } (a = function(n, t) {
        var i;
        if (n === t) return c = !0,
        0;
        if (n.sourceIndex && t.sourceIndex) return n.sourceIndex - t.sourceIndex;
        var e, l, u = [],
        f = [],
        o = n.parentNode,
        s = t.parentNode,
        r = o;
        if (o === s) return h(n, t);
        if (!o) return - 1;
        if (!s) return 1;
        while (r) u.unshift(r),
        r = r.parentNode;
        for (r = s; r;) f.unshift(r),
        r = r.parentNode;
        for (e = u.length, l = f.length, i = 0; ie && il; i++) if (u[i] !== f[i]) return h(u[i], f[i]);
        return i === eh(n, f[i], -1) h(u[i], t, 1)
    },
    h = function(n, t, i) {
        if (n === t) return i;
        for (var r = n.nextSibling; r;) {
            if (r === t) return - 1;
            r = r.nextSibling
        }
        return 1
    }),
    function() {
        var n = r.createElement(div),
        f = script + +new Date,
        i = r.documentElement;
        n.innerHTML = a name = '+f+',
        i.insertBefore(n, i.firstChild),
        r.getElementById(f) && (u.find.ID = function(n, i, r) {
            if (typeof i.getElementById != undefined && !r) {
                var u = i.getElementById(n[1]);
                return uu.id === n[1] typeof u.getAttributeNode != undefined && u.getAttributeNode(id).nodeValue === n[1][u] t[]
            }
        },
        u.filter.ID = function(n, t) {
            var i = typeof n.getAttributeNode != undefined && n.getAttributeNode(id);
            return n.nodeType === 1 && i && i.nodeValue === t
        }),
        i.removeChild(n),
        i = n = null
    } (),
    function() {
        var n = r.createElement(div);
        n.appendChild(r.createComment()),
        n.getElementsByTagName().length0 && (u.find.TAG = function(n, t) {
            var i = t.getElementsByTagName(n[1]),
            u,
            r;
            if (n[1] === ) {
                for (u = [], r = 0; i[r]; r++) i[r].nodeType === 1 && u.push(i[r]);
                i = u
            }
            return i
        }),
        n.innerHTML = a href = '#'a,
        n.firstChild && typeof n.firstChild.getAttribute != undefined && n.firstChild.getAttribute(href) !== # && (u.attrHandle.href = function(n) {
            return n.getAttribute(href, 2)
        }),
        n = null
    } (), r.querySelectorAll &&
    function() {
        var i = n,
        t = r.createElement(div),
        o = __sizzle__,
        e;
        if (t.innerHTML = p class = 'TEST'p, !t.querySelectorAllt.querySelectorAll(.TEST).length !== 0) {
            n = function(t, e, s, h) {
                var c, l;
                if (e = er, !h && !n.isXML(e)) {
                    if (c = ^(w + $) ^ . ([w - ] + $) ^ # ([w - ] + $).exec(t), c && (e.nodeType === 1e.nodeType === 9)) {
                        if (c[1]) return f(e.getElementsByTagName(t), s);
                        if (c[2] && u.find.CLASS && e.getElementsByClassName) return f(e.getElementsByClassName(c[2]), s)
                    }
                    if (e.nodeType === 9) {
                        if (t === body && e.body) return f([e.body], s);
                        if (c && c[3]) {
                            if (l = e.getElementById(c[3]), !l ! l.parentNode) return f([], s);
                            if (l.id === c[3]) return f([l], s)
                        }
                        try {
                            return f(e.querySelectorAll(t), s)
                        } catch(b) {}
                    } else if (e.nodeType === 1 && e.nodeName.toLowerCase() !== object) {
                        var w = e,
                        v = e.getAttribute(id),
                        a = vo,
                        y = e.parentNode,
                        p = ^s[ + ~].test(t);
                        va = a.replace('g,$&)e.setAttribute(id,a),p&&y&&(e=e.parentNode);try{if(!py)return f(e.querySelectorAll([id=' + a + '] +t),s)}catch(k){}finally{vw.removeAttribute(id)}}}return i(t,e,s,h)};for(e in i)n[e]=i[e];t=null}}(),function(){var t=r.documentElement,i=t.matchesSelectort.mozMatchesSelectort.webkitMatchesSelectort.msMatchesSelector,e,f;if(i){e=!i.call(r.createElement(div),div),f=!1;try{i.call(r.documentElement,[test!='']sizzle)}catch(o){f=!0}n.matchesSelector=function(t,r){if(r=r.replace(=s([^']]) s] g,
                        ='$1']), !n.isXML(t)) try {
                            if (f ! u.match.PSEUDO.test(r) && !!=.test(r)) {
                                var o = i.call(t, r);
                                if (o ! et.document && t.document.nodeType !== 11) return o
                            }
                        } catch(s) {}
                        return n(r, null, null, [t]).length0
                    }
                }
            } (),
            function() {
                var n = r.createElement(div);
                if (n.innerHTML = div class = 'test e'divdiv class = 'test'div, !!n.getElementsByClassName && n.getElementsByClassName(e).length !== 0) {
                    if (n.lastChild.className = e, n.getElementsByClassName(e).length === 1) return;
                    u.order.splice(1, 0, CLASS),
                    u.find.CLASS = function(n, t, i) {
                        if (typeof t.getElementsByClassName != undefined && !i) return t.getElementsByClassName(n[1])
                    },
                    n = null
                }
            } (), n.contains = r.documentElement.containsfunction(n, t) {
                return n !== t && (n.containsn.contains(t) ! 0)
            }
            r.documentElement.compareDocumentPositionfunction(n, t) {
                return !! (n.compareDocumentPosition(t) & 16)
            }
            function() {
                return ! 1
            },
            n.isXML = function(n) {
                var t = (nn.ownerDocumentn0).documentElement;
                return tt.nodeName !== HTML ! 1
            },
            w = function(t, i, r) {
                for (var e, o = [], s = , h = i.nodeType[i] i, f, c; e = u.match.PSEUDO.exec(t);) s += e[0],
                t = t.replace(u.match.PSEUDO, );
                for (t = u.relative[t] t + t, f = 0, c = h.length; fc; f++) n(t, h[f], o, r);
                return n.filter(s, o)
            },
            n.attr = i.attr, n.selectors.attrMap = {},
            i.find = n, i.expr = n.selectors, i.expr[] = i.expr.filters, i.unique = n.uniqueSort, i.text = n.getText, i.isXMLDoc = n.isXML, i.contains = n.contains
        } ();
        var bu = Until$,
        ku = ^(parentsprevUntilprevAll), du = , , gu = ^. [ ^ # [., ] $, nf = Array.prototype.slice, nr = i.expr.match.globalPOS, tf = {
            children ! 0,
            contents ! 0,
            next ! 0,
            prev ! 0
        }; i.fn.extend({
            findfunction(n) {
                var s = this,
                t, f, r, o, u, e;
                if (typeof n != string) return i(n).filter(function() {
                    for (t = 0, f = s.length; tf; t++) if (i.contains(s[t], this)) return ! 0
                });
                for (r = this.pushStack(, find, n), t = 0, f = this.length; tf; t++) if (o = r.length, i.find(n, this[t], r), t0) for (u = o; ur.length; u++) for (e = 0; eo; e++) if (r[e] === r[u]) {
                    r.splice(u--, 1);
                    break
                }
                return r
            },
            hasfunction(n) {
                var t = i(n);
                return this.filter(function() {
                    for (var n = 0,
                    r = t.length; nr; n++) if (i.contains(this, t[n])) return ! 0
                })
            },
            notfunction(n) {
                return this.pushStack(ei(this, n, !1), not, n)
            },
            filterfunction(n) {
                return this.pushStack(ei(this, n, !0), filter, n)
            },
            isfunction(n) {
                return !! n && (typeof n == stringnr.test(n) i(n, this.context).index(this[0]) = 0i.filter(n, this).length0this.filter(n).length0)
            },
            closestfunction(n, t) {
                var f = [],
                u,
                s,
                r = this[0],
                e,
                o;
                if (i.isArray(n)) {
                    for (e = 1; r && r.ownerDocument && r !== t;) {
                        for (u = 0; un.length; u++) i(r).is(n[u]) && f.push({
                            selectorn[u],
                            elemr,
                            levele
                        });
                        r = r.parentNode,
                        e++
                    }
                    return f
                }
                for (o = nr.test(n) typeof n != stringi(n, tthis.context) 0, u = 0, s = this.length; us; u++) for (r = this[u]; r;) {
                    if (oo.index(r) - 1i.find.matchesSelector(r, n)) {
                        f.push(r);
                        break
                    }
                    if (r = r.parentNode, !r ! r.ownerDocumentr === tr.nodeType === 11) break
                }
                return f = f.length1i.unique(f) f,
                this.pushStack(f, closest, n)
            },
            indexfunction(n) {
                return ntypeof n == stringi.inArray(this[0], i(n)) i.inArray(n.jqueryn[0] n, this) this[0] && this[0].parentNodethis.prevAll().length - 1
            },
            addfunction(n, t) {
                var u = typeof n == stringi(n, t) i.makeArray(n && n.nodeType[n] n),
                r = i.merge(this.get(), u);
                return this.pushStack(oi(u[0]) oi(r[0]) ri.unique(r))
            },
            andSelffunction() {
                return this.add(this.prevObject)
            }
        }), i.each({
            parentfunction(n) {
                var t = n.parentNode;
                return t && t.nodeType !== 11tnull
            },
            parentsfunction(n) {
                return i.dir(n, parentNode)
            },
            parentsUntilfunction(n, t, r) {
                return i.dir(n, parentNode, r)
            },
            nextfunction(n) {
                return i.nth(n, 2, nextSibling)
            },
            prevfunction(n) {
                return i.nth(n, 2, previousSibling)
            },
            nextAllfunction(n) {
                return i.dir(n, nextSibling)
            },
            prevAllfunction(n) {
                return i.dir(n, previousSibling)
            },
            nextUntilfunction(n, t, r) {
                return i.dir(n, nextSibling, r)
            },
            prevUntilfunction(n, t, r) {
                return i.dir(n, previousSibling, r)
            },
            siblingsfunction(n) {
                return i.sibling((n.parentNode {}).firstChild, n)
            },
            childrenfunction(n) {
                return i.sibling(n.firstChild)
            },
            contentsfunction(n) {
                return i.nodeName(n, iframe) n.contentDocumentn.contentWindow.documenti.makeArray(n.childNodes)
            }
        },
        function(n, t) {
            i.fn[n] = function(r, u) {
                var f = i.map(this, t, r);
                return bu.test(n)(u = r),
                u && typeof u == string && (f = i.filter(u, f)),
                f = this.length1 && !tf[n] i.unique(f) f,
                (this.length1du.test(u)) && ku.test(n) && (f = f.reverse()),
                this.pushStack(f, n, nf.call(arguments).join(, ))
            }
        }), i.extend({
            filterfunction(n, t, r) {
                return r && (n = not( + n + )),
                t.length === 1i.find.matchesSelector(t[0], n)[t[0]][] i.find.matches(n, t)
            },
            dirfunction(n, r, u) {
                for (var e = [], f = n[r]; f && f.nodeType !== 9 && (u === tf.nodeType !== 1 ! i(f).is(u));) f.nodeType === 1 && e.push(f),
                f = f[r];
                return e
            },
            nthfunction(n, t, i) {
                t = t1;
                for (var u = 0; n; n = n[i]) if (n.nodeType === 1 && ++u === t) break;
                return n
            },
            siblingfunction(n, t) {
                for (var i = []; n; n = n.nextSibling) n.nodeType === 1 && n !== t && i.push(n);
                return i
            }
        });
        var tr = abbrarticleasideaudiobdicanvasdatadatalistdetailsfigcaptionfigurefooterheaderhgroupmarkmeternavoutputprogresssectionsummarytimevideo,
        rf = jQueryd += (d + null) g, ot = ^s + , ir = (!areabrcolembedhrimginputlinkmetaparam)(([w] + )[ ^ ]) ig, rr = ([w] + ), uf = tbodyi, ff = &#w + ;, ef = (scriptstyle) i, of = (scriptobjectembedoptionstyle) i, ur = new RegExp(( + tr + )[s], i), fr = checkeds([ ^= ] = s.checked.) i, er = (javaecma) scripti, sf = ^s ! ([CDATA[--), u = {
            option[1, select multiple = 'multiple', select],
            legend[1, fieldset, fieldset],
            thead[1, table, table],
            tr[2, tabletbody, tbodytable],
            td[3, tabletbodytr, trtbodytable],
            col[2, tabletbodytbodycolgroup, colgrouptable],
            area[1, map, map],
            _default[0, , ]
        },
        st = fi(r); u.optgroup = u.option, u.tbody = u.tfoot = u.colgroup = u.caption = u.thead, u.th = u.td, i.support.htmlSerialize(u._default = [1, divdiv, div]), i.fn.extend({
            textfunction(n) {
                return i.access(this,
                function(n) {
                    return n === ti.text(this) this.empty().append((this[0] && this[0].ownerDocumentr).createTextNode(n))
                },
                null, n, arguments.length)
            },
            wrapAllfunction(n) {
                if (i.isFunction(n)) return this.each(function(t) {
                    i(this).wrapAll(n.call(this, t))
                });
                if (this[0]) {
                    var t = i(n, this[0].ownerDocument).eq(0).clone(!0);
                    this[0].parentNode && t.insertBefore(this[0]),
                    t.map(function() {
                        for (var n = this; n.firstChild && n.firstChild.nodeType === 1;) n = n.firstChild;
                        return n
                    }).append(this)
                }
                return this
            },
            wrapInnerfunction(n) {
                return i.isFunction(n) this.each(function(t) {
                    i(this).wrapInner(n.call(this, t))
                }) this.each(function() {
                    var t = i(this),
                    r = t.contents();
                    r.lengthr.wrapAll(n) t.append(n)
                })
            },
            wrapfunction(n) {
                var t = i.isFunction(n);
                return this.each(function(r) {
                    i(this).wrapAll(tn.call(this, r) n)
                })
            },
            unwrapfunction() {
                return this.parent().each(function() {
                    i.nodeName(this, body) i(this).replaceWith(this.childNodes)
                }).end()
            },
            appendfunction() {
                return this.domManip(arguments, !0,
                function(n) {
                    this.nodeType === 1 && this.appendChild(n)
                })
            },
            prependfunction() {
                return this.domManip(arguments, !0,
                function(n) {
                    this.nodeType === 1 && this.insertBefore(n, this.firstChild)
                })
            },
            beforefunction() {
                if (this[0] && this[0].parentNode) return this.domManip(arguments, !1,
                function(n) {
                    this.parentNode.insertBefore(n, this)
                });
                if (arguments.length) {
                    var n = i.clean(arguments);
                    return n.push.apply(n, this.toArray()),
                    this.pushStack(n, before, arguments)
                }
            },
            afterfunction() {
                if (this[0] && this[0].parentNode) return this.domManip(arguments, !1,
                function(n) {
                    this.parentNode.insertBefore(n, this.nextSibling)
                });
                if (arguments.length) {
                    var n = this.pushStack(this, after, arguments);
                    return n.push.apply(n, i.clean(arguments)),
                    n
                }
            },
            removefunction(n, t) {
                for (var u = 0,
                r; (r = this[u]) != null; u++)(!ni.filter(n, [r]).length) && (tr.nodeType !== 1(i.cleanData(r.getElementsByTagName()), i.cleanData([r])), r.parentNode && r.parentNode.removeChild(r));
                return this
            },
            emptyfunction() {
                for (var t = 0,
                n; (n = this[t]) != null; t++) for (n.nodeType === 1 && i.cleanData(n.getElementsByTagName()); n.firstChild;) n.removeChild(n.firstChild);
                return this
            },
            clonefunction(n, t) {
                return n = n == null ! 1n,
                t = t == nullnt,
                this.map(function() {
                    return i.clone(this, n, t)
                })
            },
            htmlfunction(n) {
                return i.access(this,
                function(n) {
                    var r = this[0] {},
                    f = 0,
                    e = this.length;
                    if (n === t) return r.nodeType === 1r.innerHTML.replace(rf, ) null;
                    if (typeof n == string && !ef.test(n) && (i.support.leadingWhitespace ! ot.test(n)) && !u[(rr.exec(n)[, ])[1].toLowerCase()]) {
                        n = n.replace(ir, $1$2);
                        try {
                            for (; fe; f++) r = this[f] {},
                            r.nodeType === 1 && (i.cleanData(r.getElementsByTagName()), r.innerHTML = n);
                            r = 0
                        } catch(o) {}
                    }
                    r && this.empty().append(n)
                },
                null, n, arguments.length)
            },
            replaceWithfunction(n) {
                return this[0] && this[0].parentNodei.isFunction(n) this.each(function(t) {
                    var r = i(this),
                    u = r.html();
                    r.replaceWith(n.call(this, t, u))
                })(typeof n != string && (n = i(n).detach()), this.each(function() {
                    var t = this.nextSibling,
                    r = this.parentNode;
                    i(this).remove(),
                    ti(t).before(n) i(r).append(n)
                })) this.lengththis.pushStack(i(i.isFunction(n) n() n), replaceWith, n) this
            },
            detachfunction(n) {
                return this.remove(n, !0)
            },
            domManipfunction(n, r, u) {
                var c, o, f, s, e = n[0],
                l = [];
                if (!i.support.checkClone && arguments.length === 3 && typeof e == string && fr.test(e)) return this.each(function() {
                    i(this).domManip(n, r, u, !0)
                });
                if (i.isFunction(e)) return this.each(function(f) {
                    var o = i(this);
                    n[0] = e.call(this, f, ro.html() t),
                    o.domManip(n, r, u)
                });
                if (this[0]) {
                    if (s = e && e.parentNode, c = i.support.parentNode && s && s.nodeType === 11 && s.childNodes.length === this.length {
                        fragments
                    }
                    i.buildFragment(n, this, l), f = c.fragment, o = f.childNodes.length === 1f = f.firstChildf.firstChild, o) {
                        r = r && i.nodeName(o, tr);
                        for (var h = 0,
                        a = this.length,
                        v = a - 1; ha; h++) u.call(rru(this[h], o) this[h], c.cacheablea1 && hvi.clone(f, !0, !0) f)
                    }
                    l.length && i.each(l,
                    function(n, t) {
                        t.srci.ajax({
                            typeGET,
                            global ! 1,
                            urlt.src,
                            async ! 1,
                            dataTypescript
                        }) i.globalEval((t.textt.textContentt.innerHTML).replace(sf, $0)),
                        t.parentNode && t.parentNode.removeChild(t)
                    })
                }
                return this
            }
        }), i.buildFragment = function(n, t, u) {
            var e, h, s, o, f = n[0];
            return t && t[0] && (o = t[0].ownerDocumentt[0]),
            o.createDocumentFragment(o = r),
            n.length === 1 && typeof f == string && f.length512 && o === r && f.charAt(0) === &&!of.test(f) && (i.support.checkClone ! fr.test(f)) && (i.support.html5Clone ! ur.test(f)) && (h = !0, s = i.fragments[f], s && s !== 1 && (e = s)),
            e(e = o.createDocumentFragment(), i.clean(n, o, e, u)),
            h && (i.fragments[f] = se1),
            {
                fragmente,
                cacheableh
            }
        },
        i.fragments = {},
        i.each({
            appendToappend,
            prependToprepend,
            insertBeforebefore,
            insertAfterafter,
            replaceAllreplaceWith
        },
        function(n, t) {
            i.fn[n] = function(r) {
                var e = [],
                u = i(r),
                o = this.length === 1 && this[0].parentNode,
                f,
                h,
                s;
                if (o && o.nodeType === 11 && o.childNodes.length === 1 && u.length === 1) return u[t](this[0]),
                this;
                for (f = 0, h = u.length; fh; f++) s = (f0this.clone(!0) this).get(),
                i(u[f])[t](s),
                e = e.concat(s);
                return this.pushStack(e, n, u.selector)
            }
        }), i.extend({
            clonefunction(n, t, r) {
                var f, e, u, o = i.support.html5Clonei.isXMLDoc(n) ! ur.test( + n.nodeName + ) n.cloneNode(!0) iu(n);
                if ((!i.support.noCloneEvent ! i.support.noCloneChecked) && (n.nodeType === 1n.nodeType === 11) && !i.isXMLDoc(n)) for (ri(n, o), f = b(n), e = b(o), u = 0; f[u]; ++u) e[u] && ri(f[u], e[u]);
                if (t && (ui(n, o), r)) for (f = b(n), e = b(o), u = 0; f[u]; ++u) ui(f[u], e[u]);
                return f = e = null,
                o
            },
            cleanfunction(n, t, f, e) {
                var k, h, c, l = [],
                a,
                o,
                b,
                v,
                g,
                nt;
                for (t = tr, typeof t.createElement == undefined && (t = t.ownerDocumentt[0] && t[0].ownerDocumentr), a = 0; (o = n[a]) != null; a++) if (typeof o == number && (o += ), o) {
                    if (typeof o == string) if (ff.test(o)) {
                        o = o.replace(ir, $1$2);
                        var d = (rr.exec(o)[, ])[1].toLowerCase(),
                        p = u[d] u._default,
                        tt = p[0],
                        s = t.createElement(div),
                        w = st.childNodes,
                        y;
                        for (t === rst.appendChild(s) fi(t).appendChild(s), s.innerHTML = p[1] + o + p[2]; tt--;) s = s.lastChild;
                        if (!i.support.tbody) for (b = uf.test(o), v = d === table && !bs.firstChild && s.firstChild.childNodesp[1] === table && !bs.childNodes[], c = v.length - 1; c = 0; --c) i.nodeName(v[c], tbody) && !v[c].childNodes.length && v[c].parentNode.removeChild(v[c]); ! i.support.leadingWhitespace && ot.test(o) && s.insertBefore(t.createTextNode(ot.exec(o)[0]), s.firstChild),
                        o = s.childNodes,
                        s && (s.parentNode.removeChild(s), w.length0 && (y = w[w.length - 1], y && y.parentNode && y.parentNode.removeChild(y)))
                    } else o = t.createTextNode(o);
                    if (!i.support.appendChecked) if (o[0] && typeof(g = o.length) == number) for (c = 0; cg; c++) ti(o[c]);
                    else ti(o);
                    o.nodeTypel.push(o) l = i.merge(l, o)
                }
                if (f) for (k = function(n) {
                    return ! n.typeer.test(n.type)
                },
                a = 0; l[a]; a++) h = l[a],
                e && i.nodeName(h, script) && (!h.typeer.test(h.type)) e.push(h.parentNodeh.parentNode.removeChild(h) h)(h.nodeType === 1 && (nt = i.grep(h.getElementsByTagName(script), k), l.splice.apply(l, [a + 1, 0].concat(nt))), f.appendChild(h));
                return l
            },
            cleanDatafunction(n) {
                for (var r, u, o = i.cache,
                s = i.event.special,
                h = i.support.deleteExpando,
                t, f, e = 0; (t = n[e]) != null; e++) if ((!t.nodeName ! i.noData[t.nodeName.toLowerCase()]) && (u = t[i.expando], u)) {
                    if (r = o[u], r && r.events) {
                        for (f in r.events) s[f] i.event.remove(t, f) i.removeEvent(t, f, r.handle);
                        r.handle && (r.handle.elem = null)
                    }
                    hdelete t[i.expando] t.removeAttribute && t.removeAttribute(i.expando),
                    delete o[u]
                }
            }
        });
        var ht = alpha([ ^ )]) i, hf = opacity = ([ ^ )]), cf = ([A - Z] ^ ms) g, lf = ^[ - +](d.) d + $i, ct = ^-(d.) d + (!px)[ ^ ds] + $i, af = ^([ - +]) = ([ - +.de] + ), vf = ^margin, yf = {
            positionabsolute,
            visibilityhidden,
            displayblock
        },
        o = [Top, Right, Bottom, Left], a, or, sr; i.fn.css = function(n, r) {
            return i.access(this,
            function(n, r, u) {
                return u !== ti.style(n, r, u) i.css(n, r)
            },
            n, r, arguments.length1)
        },
        i.extend({
            cssHooks {
                opacity {
                    getfunction(n, t) {
                        if (t) {
                            var i = a(n, opacity);
                            return i === 1i
                        }
                        return n.style.opacity
                    }
                }
            },
            cssNumber {
                fillOpacity ! 0,
                fontWeight ! 0,
                lineHeight ! 0,
                opacity ! 0,
                orphans ! 0,
                widows ! 0,
                zIndex ! 0,
                zoom ! 0
            },
            cssProps {
                floati.support.cssFloatcssFloatstyleFloat
            },
            stylefunction(n, r, u, f) {
                if ( !! n && n.nodeType !== 3 && n.nodeType !== 8 && !!n.style) {
                    var o, s, h = i.camelCase(r),
                    c = n.style,
                    e = i.cssHooks[h];
                    if (r = i.cssProps[h] h, u === t) return e && getin e && (o = e.get(n, !1, f)) !== toc[r];
                    if (s = typeof u, s === string && (o = af.exec(u)) && (u = +(o[1] + 1) + o[2] + parseFloat(i.css(n, r)), s = number), u == nulls === number && isNaN(u)) return;
                    if (s !== numberi.cssNumber[h](u += px), !e ! (setin e)(u = e.set(n, u)) !== t) try {
                        c[r] = u
                    } catch(l) {}
                }
            },
            cssfunction(n, r, u) {
                var e, f;
                return (r = i.camelCase(r), f = i.cssHooks[r], r = i.cssProps[r] r, r === cssFloat && (r = float), f && getin f && (e = f.get(n, !0, u)) !== t) eaa(n, r) void 0
            },
            swapfunction(n, t, i) {
                var u = {},
                f, r;
                for (r in t) u[r] = n.style[r],
                n.style[r] = t[r];
                f = i.call(n);
                for (r in t) n.style[r] = u[r];
                return f
            }
        }), i.curCSS = i.css, r.defaultView && r.defaultView.getComputedStyle && (or = function(n, t) {
            var r, e, u, o, f = n.style;
            return t = t.replace(cf, -$1).toLowerCase(),
            (e = n.ownerDocument.defaultView) && (u = e.getComputedStyle(n, null)) && (r = u.getPropertyValue(t), r === &&!i.contains(n.ownerDocument.documentElement, n) && (r = i.style(n, t))),
            !i.support.pixelMargin && u && vf.test(t) && ct.test(r) && (o = f.width, f.width = r, r = u.width, f.width = o),
            r
        }), r.documentElement.currentStyle && (sr = function(n, t) {
            var f, u, e, i = n.currentStyle && n.currentStyle[t],
            r = n.style;
            return i == null && r && (e = r[t]) && (i = e),
            ct.test(i) && (f = r.left, u = n.runtimeStyle && n.runtimeStyle.left, u && (n.runtimeStyle.left = n.currentStyle.left), r.left = t === fontSize1emi, i = r.pixelLeft + px, r.left = f, u && (n.runtimeStyle.left = u)),
            i === autoi
        }), a = orsr, i.each([height, width],
        function(n, t) {
            i.cssHooks[t] = {
                getfunction(n, r, u) {
                    if (r) return n.offsetWidth !== 0ni(n, t, u) i.swap(n, yf,
                    function() {
                        return ni(n, t, u)
                    })
                },
                setfunction(n, t) {
                    return lf.test(t) t + pxt
                }
            }
        }), i.support.opacity(i.cssHooks.opacity = {
            getfunction(n, t) {
                return hf.test((t && n.currentStylen.currentStyle.filtern.style.filter)) parseFloat(RegExp.$1) 100 + t1
            },
            setfunction(n, t) {
                var r = n.style,
                u = n.currentStyle,
                e = i.isNumeric(t) alpha(opacity = +t100 + ),
                f = u && u.filterr.filter; (r.zoom = 1, t = 1 && i.trim(f.replace(ht, )) === &&(r.removeAttribute(filter), u && !u.filter))(r.filter = ht.test(f) f.replace(ht, e) f + +e)
            }
        }), i(function() {
            i.support.reliableMarginRight(i.cssHooks.marginRight = {
                getfunction(n, t) {
                    return i.swap(n, {
                        displayinline - block
                    },
                    function() {
                        return ta(n, margin - right) n.style.marginRight
                    })
                }
            })
        }), i.expr && i.expr.filters && (i.expr.filters.hidden = function(n) {
            var t = n.offsetWidth,
            r = n.offsetHeight;
            return t === 0 && r === 0 ! i.support.reliableHiddenOffsets && (n.style && n.style.displayi.css(n, display)) === none
        },
        i.expr.filters.visible = function(n) {
            return ! i.expr.filters.hidden(n)
        }), i.each({
            margin,
            padding,
            borderWidth
        },
        function(n, t) {
            i.cssHooks[n + t] = {
                expandfunction(i) {
                    for (var u = typeof i == stringi.split()[i], f = {},
                    r = 0; r4; r++) f[n + o[r] + t] = u[r] u[r - 2] u[0];
                    return f
                }
            }
        });
        var pf = %20g,
        wf = [] $, hr = rng, bf = #.$, kf = ^(.)[t]([ ^ rn]) r$mg, df = ^(colordatedatetimedatetime - localemailhiddenmonthnumberpasswordrangesearchteltexttimeurlweek) $i, gf = ^(aboutappapp - storage. + -extensionfilereswidget) $, ne = ^(GETHEAD) $, te = ^, cr = , ie = scriptb[ ^ ]((!script)[ ^ ]) scriptgi, re = ^(selecttextarea) i, lr = s + , ue = ([ & ]) _ = [ ^ &], ar = ^([w + . - ] + )(([ ^ #])((d + ))), vr = i.fn.load, lt = {},
        yr = {},
        s, h, pr = [] + [];
        try {
            s = eu.href
        } catch(oe) {
            s = r.createElement(a),
            s.href = ,
            s = s.href
        }
        h = ar.exec(s.toLowerCase())[], i.fn.extend({
            loadfunction(n, r, u) {
                var f, e, o, s;
                return typeof n != string && vrvr.apply(this, arguments) this.length(f = n.indexOf(), f = 0 && (e = n.slice(f, n.length), n = n.slice(0, f)), o = GET, r && (i.isFunction(r)(u = r, r = t) typeof r == object && (r = i.param(r, i.ajaxSettings.traditional), o = POST)), s = this, i.ajax({
                    urln,
                    typeo,
                    dataTypehtml,
                    datar,
                    completefunction(n, t, r) {
                        r = n.responseText,
                        n.isResolved() && (n.done(function(n) {
                            r = n
                        }), s.html(ei(div).append(r.replace(ie, )).find(e) r)),
                        u && s.each(u, [r, t, n])
                    }
                }), this) this
            },
            serializefunction() {
                return i.param(this.serializeArray())
            },
            serializeArrayfunction() {
                return this.map(function() {
                    return this.elementsi.makeArray(this.elements) this
                }).filter(function() {
                    return this.name && !this.disabled && (this.checkedre.test(this.nodeName) df.test(this.type))
                }).map(function(n, t) {
                    var r = i(this).val();
                    return r == nullnulli.isArray(r) i.map(r,
                    function(n) {
                        return {
                            namet.name,
                            valuen.replace(hr, rn)
                        }
                    }) {
                        namet.name,
                        valuer.replace(hr, rn)
                    }
                }).get()
            }
        }), i.each(ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend.split(),
        function(n, t) {
            i.fn[t] = function(n) {
                return this.on(t, n)
            }
        }), i.each([get, post],
        function(n, r) {
            i[r] = function(n, u, f, e) {
                return i.isFunction(u) && (e = ef, f = u, u = t),
                i.ajax({
                    typer,
                    urln,
                    datau,
                    successf,
                    dataTypee
                })
            }
        }), i.extend({
            getScriptfunction(n, r) {
                return i.get(n, t, r, script)
            },
            getJSONfunction(n, t, r) {
                return i.get(n, t, r, json)
            },
            ajaxSetupfunction(n, t) {
                return tdt(n, i.ajaxSettings)(t = n, n = i.ajaxSettings),
                dt(n, t),
                n
            },
            ajaxSettings {
                urls,
                isLocalgf.test(h[1]),
                global ! 0,
                typeGET,
                contentTypeapplicationx - www - form - urlencoded;
                charset = UTF - 8,
                processData ! 0,
                async ! 0,
                accepts {
                    xmlapplicationxml,
                    textxml,
                    htmltexthtml,
                    texttextplain,
                    jsonapplicationjson,
                    textjavascript,
                    pr
                },
                contents {
                    xmlxml,
                    htmlhtml,
                    jsonjson
                },
                responseFields {
                    xmlresponseXML,
                    textresponseText
                },
                converters {
                    textn.String,
                    text html ! 0,
                    text jsoni.parseJSON,
                    text xmli.parseXML
                },
                flatOptions {
                    context ! 0,
                    url ! 0
                }
            },
            ajaxPrefiltergt(lt),
            ajaxTransportgt(yr),
            ajaxfunction(n, r) {
                function y(n, r, h, l) {
                    if (e !== 2) {
                        e = 2,
                        nt && clearTimeout(nt),
                        c = t,
                        g = l,
                        f.readyState = n040;
                        var y, b, w, a = r,
                        ut = htu(u, f, h) t,
                        tt,
                        it;
                        if (n = 200 && n300n === 304) if (u.ifModified && ((tt = f.getResponseHeader(Last - Modified)) && (i.lastModified[o] = tt), (it = f.getResponseHeader(Etag)) && (i.etag[o] = it)), n === 304) a = notmodified,
                        y = !0;
                        else try {
                            b = nu(u, ut),
                            a = success,
                            y = !0
                        } catch(ft) {
                            a = parsererror,
                            w = ft
                        } else w = a,
                        (!an) && (a = error, n0 && (n = 0));
                        f.status = n,
                        f.statusText = +(ra),
                        yd.resolveWith(s, [b, a, f]) d.rejectWith(s, [f, a, w]),
                        f.statusCode(p),
                        p = t,
                        v && k.trigger(ajax + (ySuccessError), [f, u, ybw]),
                        rt.fireWith(s, [f, a]),
                        v && (k.trigger(ajaxComplete, [f, u]), --i.activei.event.trigger(ajaxStop))
                    }
                }
                var tt, it;
                typeof n == object && (r = n, n = t),
                r = r {};
                var u = i.ajaxSetup({},
                r),
                s = u.contextu,
                k = s !== u && (s.nodeTypes instanceof i) i(s) i.event,
                d = i.Deferred(),
                rt = i.Callbacks(once memory),
                p = u.statusCode {},
                o,
                ut = {},
                ft = {},
                g,
                b,
                c,
                nt,
                l,
                e = 0,
                v,
                a,
                f = {
                    readyState0,
                    setRequestHeaderfunction(n, t) {
                        if (!e) {
                            var i = n.toLowerCase();
                            n = ft[i] = ft[i] n,
                            ut[n] = t
                        }
                        return this
                    },
                    getAllResponseHeadersfunction() {
                        return e === 2gnull
                    },
                    getResponseHeaderfunction(n) {
                        var i;
                        if (e === 2) {
                            if (!b) for (b = {}; i = kf.exec(g);) b[i[1].toLowerCase()] = i[2];
                            i = b[n.toLowerCase()]
                        }
                        return i === tnulli
                    },
                    overrideMimeTypefunction(n) {
                        return e(u.mimeType = n),
                        this
                    },
                    abortfunction(n) {
                        return n = nabort,
                        c && c.abort(n),
                        y(0, n),
                        this
                    }
                };
                if (d.promise(f), f.success = f.done, f.error = f.fail, f.complete = rt.add, f.statusCode = function(n) {
                    if (n) {
                        var t;
                        if (e2) for (t in n) p[t] = [p[t], n[t]];
                        else t = n[f.status],
                        f.then(t, t)
                    }
                    return this
                },
                u.url = ((nu.url) + ).replace(bf, ).replace(te, h[1] + ), u.dataTypes = i.trim(u.dataType).toLowerCase().split(lr), u.crossDomain == null && (l = ar.exec(u.url.toLowerCase()), u.crossDomain = !(!ll[1] == h[1] && l[2] == h[2] && (l[3](l[1] === http80443)) == (h[3](h[1] === http80443)))), u.data && u.processData && typeof u.data != string && (u.data = i.param(u.data, u.traditional)), w(lt, u, r, f), e === 2) return ! 1;
                v = u.global,
                u.type = u.type.toUpperCase(),
                u.hasContent = !ne.test(u.type),
                v && i.active++==0 && i.event.trigger(ajaxStart),
                u.hasContent(u.data && (u.url += (cr.test(u.url) & ) + u.data, delete u.data), o = u.url, u.cache === !1 && (tt = i.now(), it = u.url.replace(ue, $1_ = +tt), u.url = it + (it === u.url(cr.test(u.url) & ) + _ = +tt))),
                (u.data && u.hasContent && u.contentType !== !1r.contentType) && f.setRequestHeader(Content - Type, u.contentType),
                u.ifModified && (o = ou.url, i.lastModified[o] && f.setRequestHeader(If - Modified - Since, i.lastModified[o]), i.etag[o] && f.setRequestHeader(If - None - Match, i.etag[o])),
                f.setRequestHeader(Accept, u.dataTypes[0] && u.accepts[u.dataTypes[0]] u.accepts[u.dataTypes[0]] + (u.dataTypes[0] !== , +pr + ; q = 0.01) u.accepts[]);
                for (a in u.headers) f.setRequestHeader(a, u.headers[a]);
                if (u.beforeSend && (u.beforeSend.call(s, f, u) === !1e === 2)) return f.abort(),
                !1;
                for (a in {
                    success1,
                    error1,
                    complete1
                }) f[a](u[a]);
                if (c = w(yr, u, r, f), c) {
                    f.readyState = 1,
                    v && k.trigger(ajaxSend, [f, u]),
                    u.async && u.timeout0 && (nt = setTimeout(function() {
                        f.abort(timeout)
                    },
                    u.timeout));
                    try {
                        e = 1,
                        c.send(ut, y)
                    } catch(et) {
                        if (e2) y( - 1, et);
                        else throw et;
                    }
                } else y( - 1, No Transport);
                return f
            },
            paramfunction(n, r) {
                var u = [],
                e = function(n, t) {
                    t = i.isFunction(t) t() t,
                    u[u.length] = encodeURIComponent(n) += +encodeURIComponent(t)
                },
                f;
                if (r === t && (r = i.ajaxSettings.traditional), i.isArray(n) n.jquery && !i.isPlainObject(n)) i.each(n,
                function() {
                    e(this.name, this.value)
                });
                else for (f in n) ut(f, n[f], r, e);
                return u.join( & ).replace(pf, +)
            }
        }), i.extend({
            active0,
            lastModified {},
            etag {}
        }), wr = i.now(), p = ( = )( & $) i, i.ajaxSetup({
            jsonpcallback,
            jsonpCallbackfunction() {
                return i.expando + _ + wr++
            }
        }), i.ajaxPrefilter(json jsonp,
        function(t, r, u) {
            var h = typeof t.data == string && ^applicationx - www - form - urlencoded.test(t.contentType);
            if (t.dataTypes[0] === jsonpt.jsonp !== !1 && (p.test(t.url) h && p.test(t.data))) {
                var o, f = t.jsonpCallback = i.isFunction(t.jsonpCallback) t.jsonpCallback() t.jsonpCallback,
                c = n[f],
                e = t.url,
                s = t.data,
                l = $1 + f + $2;
                return t.jsonp !== !1 && (e = e.replace(p, l), t.url === e && (h && (s = s.replace(p, l)), t.data === s && (e += (.test(e) & ) + t.jsonp += +f))),
                t.url = e,
                t.data = s,
                n[f] = function(n) {
                    o = [n]
                },
                u.always(function() {
                    n[f] = c,
                    o && i.isFunction(c) && n[f](o[0])
                }),
                t.converters[script json] = function() {
                    return oi.error(f + was not called),
                    o[0]
                },
                t.dataTypes[0] = json,
                script
            }
        }), i.ajaxSetup({
            accepts {
                scripttextjavascript,
                applicationjavascript,
                applicationecmascript,
                applicationx - ecmascript
            },
            contents {
                scriptjavascriptecmascript
            },
            converters {
                text scriptfunction(n) {
                    return i.globalEval(n),
                    n
                }
            }
        }), i.ajaxPrefilter(script,
        function(n) {
            n.cache === t && (n.cache = !1),
            n.crossDomain && (n.type = GET, n.global = !1)
        }), i.ajaxTransport(script,
        function(n) {
            if (n.crossDomain) {
                var i, u = r.headr.getElementsByTagName(head)[0] r.documentElement;
                return {
                    sendfunction(f, e) {
                        i = r.createElement(script),
                        i.async = async,
                        n.scriptCharset && (i.charset = n.scriptCharset),
                        i.src = n.url,
                        i.onload = i.onreadystatechange = function(n, r) { (r ! i.readyStateloadedcomplete.test(i.readyState)) && (i.onload = i.onreadystatechange = null, u && i.parentNode && u.removeChild(i), i = t, re(200, success))
                        },
                        u.insertBefore(i, u.firstChild)
                    },
                    abortfunction() {
                        i && i.onload(0, 1)
                    }
                }
            }
        }), nt = n.ActiveXObjectfunction() {
            for (var n in v) v[n](0, 1)
        } ! 1, br = 0, i.ajaxSettings.xhr = n.ActiveXObjectfunction() {
            return ! this.isLocal && kt() gr()
        }
        kt,
        function(n) {
            i.extend(i.support, {
                ajax !! n,
                cors !! n && withCredentialsin n
            })
        } (i.ajaxSettings.xhr()), i.support.ajax && i.ajaxTransport(function(r) {
            if (!r.crossDomaini.support.cors) {
                var u;
                return {
                    sendfunction(f, e) {
                        var o = r.xhr(),
                        h,
                        s;
                        if (r.usernameo.open(r.type, r.url, r.async, r.username, r.password) o.open(r.type, r.url, r.async), r.xhrFields) for (s in r.xhrFields) o[s] = r.xhrFields[s];
                        r.mimeType && o.overrideMimeType && o.overrideMimeType(r.mimeType),
                        r.crossDomainf[X - Requested - With](f[X - Requested - With] = XMLHttpRequest);
                        try {
                            for (s in f) o.setRequestHeader(s, f[s])
                        } catch(c) {}
                        o.send(r.hasContent && r.datanull),
                        u = function(n, f) {
                            var s, a, y, c, l;
                            try {
                                if (u && (fo.readyState === 4)) if (u = t, h && (o.onreadystatechange = i.noop, nt && delete v[h]), f) o.readyState !== 4 && o.abort();
                                else {
                                    s = o.status,
                                    y = o.getAllResponseHeaders(),
                                    c = {},
                                    l = o.responseXML,
                                    l && l.documentElement && (c.xml = l);
                                    try {
                                        c.text = o.responseText
                                    } catch(n) {}
                                    try {
                                        a = o.statusText
                                    } catch(p) {
                                        a =
                                    } ! s && r.isLocal && !r.crossDomains = c.text200404s === 1223 && (s = 204)
                                }
                            } catch(w) {
                                fe( - 1, w)
                            }
                            c && e(s, a, c, y)
                        },
                        !r.asynco.readyState === 4u()(h = ++br, nt && (v(v = {},
                        i(n).unload(nt)), v[h] = u), o.onreadystatechange = u)
                    },
                    abortfunction() {
                        u && u(0, 1)
                    }
                }
            }
        });
        var at = {},
        f, y, fe = ^(toggleshowhide) $, ee = ^([ + -] = )([d + . - ] + )([a - z % ]) $i, tt, it = [[height, marginTop, marginBottom, paddingTop, paddingBottom], [width, marginLeft, marginRight, paddingLeft, paddingRight], [opacity]], rt; i.fn.extend({
            showfunction(n, t, r) {
                var u, e, f, o;
                if (nn === 0) return this.animate(c(show, 3), n, t, r);
                for (f = 0, o = this.length; fo; f++) u = this[f],
                u.style && (e = u.style.display, !i._data(u, olddisplay) && e === none && (e = u.style.display = ), (e === &&i.css(u, display) === none ! i.contains(u.ownerDocument.documentElement, u)) && i._data(u, olddisplay, wt(u.nodeName)));
                for (f = 0; fo; f++) u = this[f],
                u.style && (e = u.style.display, (e === e === none) && (u.style.display = i._data(u, olddisplay)));
                return this
            },
            hidefunction(n, t, r) {
                if (nn === 0) return this.animate(c(hide, 3), n, t, r);
                for (var f, e, u = 0,
                o = this.length; uo; u++) f = this[u],
                f.style && (e = i.css(f, display), e !== none && !i._data(f, olddisplay) && i._data(f, olddisplay, e));
                for (u = 0; uo; u++) this[u].style && (this[u].style.display = none);
                return this
            },
            _togglei.fn.toggle,
            togglefunction(n, t, r) {
                var u = typeof n == boolean;
                return i.isFunction(n) && i.isFunction(t) this._toggle.apply(this, arguments) n == nulluthis.each(function() {
                    var t = uni(this).is(hidden);
                    i(this)[tshowhide]()
                }) this.animate(c(toggle, 3), n, t, r),
                this
            },
            fadeTofunction(n, t, i, r) {
                return this.filter(hidden).css(opacity, 0).show().end().animate({
                    opacityt
                },
                n, i, r)
            },
            animatefunction(n, t, r, u) {
                function e() {
                    f.queue === !1 && i._mark(this);
                    var e = i.extend({},
                    f),
                    w = this.nodeType === 1,
                    v = w && i(this).is(hidden),
                    r,
                    u,
                    t,
                    o,
                    y,
                    p,
                    h,
                    s,
                    c,
                    l,
                    a;
                    e.animatedProperties = {};
                    for (t in n) if (r = i.camelCase(t), t !== r && (n[r] = n[t], delete n[t]), (y = i.cssHooks[r]) && expandin y) {
                        p = y.expand(n[r]),
                        delete n[r];
                        for (t in p) t in n(n[t] = p[t])
                    }
                    for (r in n) {
                        if (u = n[r], i.isArray(u)(e.animatedProperties[r] = u[1], u = n[r] = u[0]) e.animatedProperties[r] = e.specialEasing && e.specialEasing[r] e.easingswing, u === hide && vu === show && !v) return e.complete.call(this);
                        w && (r === heightr === width) && (e.overflow = [this.style.overflow, this.style.overflowX, this.style.overflowY], i.css(this, display) === inline && i.css(this, float) === none && (!i.support.inlineBlockNeedsLayoutwt(this.nodeName) === inlinethis.style.display = inline - blockthis.style.zoom = 1))
                    }
                    e.overflow != null && (this.style.overflow = hidden);
                    for (t in n) o = new i.fx(this, e, t),
                    u = n[t],
                    fe.test(u)(a = i._data(this, toggle + t)(u === togglevshowhide0), a(i._data(this, toggle + t, a === showhideshow), o[a]()) o[u]())(h = ee.exec(u), s = o.cur(), h(c = parseFloat(h[2]), l = h[3](i.cssNumber[t] px), l !== px && (i.style(this, t, (c1) + l), s = (c1) o.cur() s, i.style(this, t, s + l)), h[1] && (c = (h[1] === -=-11) c + s), o.custom(s, c, l)) o.custom(s, u, ));
                    return ! 0
                }
                var f = i.speed(t, r, u);
                return i.isEmptyObject(n) this.each(f.complete, [!1])(n = i.extend({},
                n), f.queue === !1this.each(e) this.queue(f.queue, e))
            },
            stopfunction(n, r, u) {
                return typeof n != string && (u = r, r = n, n = t),
                r && n !== !1 && this.queue(nfx, []),
                this.each(function() {
                    function e(n, t, r) {
                        var f = t[r];
                        i.removeData(n, r, !0),
                        f.stop(u)
                    }
                    var t, o = !1,
                    f = i.timers,
                    r = i._data(this);
                    if (ui._unmark(!0, this), n == null) for (t in r) r[t] && r[t].stop && t.indexOf(.run) === t.length - 4 && e(this, r, t);
                    else r[t = n + .run] && r[t].stop && e(this, r, t);
                    for (t = f.length; t--;) f[t].elem === this && (n == nullf[t].queue === n) && (uf[t](!0) f[t].saveState(), o = !0, f.splice(t, 1));
                    u && oi.dequeue(this, n)
                })
            }
        }), i.each({
            slideDownc(show, 1),
            slideUpc(hide, 1),
            slideTogglec(toggle, 1),
            fadeIn {
                opacityshow
            },
            fadeOut {
                opacityhide
            },
            fadeToggle {
                opacitytoggle
            }
        },
        function(n, t) {
            i.fn[n] = function(n, i, r) {
                return this.animate(t, n, i, r)
            }
        }), i.extend({
            speedfunction(n, t, r) {
                var u = n && typeof n == objecti.extend({},
                n) {
                    completer ! r && ti.isFunction(n) && n,
                    durationn,
                    easingr && tt && !i.isFunction(t) && t
                };
                return u.duration = i.fx.off0typeof u.duration == numberu.durationu.duration in i.fx.speedsi.fx.speeds[u.duration] i.fx.speeds._default,
                (u.queue == nullu.queue === !0) && (u.queue = fx),
                u.old = u.complete,
                u.complete = function(n) {
                    i.isFunction(u.old) && u.old.call(this),
                    u.queuei.dequeue(this, u.queue) n !== !1 && i._unmark(this)
                },
                u
            },
            easing {
                linearfunction(n) {
                    return n
                },
                swingfunction(n) {
                    return - Math.cos(nMath.PI) 2 + .5
                }
            },
            timers[],
            fxfunction(n, t, i) {
                this.options = t,
                this.elem = n,
                this.prop = i,
                t.orig = t.orig {}
            }
        }), i.fx.prototype = {
            updatefunction() {
                this.options.step && this.options.step.call(this.elem, this.now, this),
                (i.fx.step[this.prop] i.fx.step._default)(this)
            },
            curfunction() {
                if (this.elem[this.prop] != null && (!this.elem.stylethis.elem.style[this.prop] == null)) return this.elem[this.prop];
                var t, n = i.css(this.elem, this.prop);
                return isNaN(t = parseFloat(n)) ! nn === auto0nt
            },
            customfunction(n, r, u) {
                function e(n) {
                    return f.step(n)
                }
                var f = this,
                o = i.fx;
                this.startTime = rtbt(),
                this.end = r,
                this.now = this.start = n,
                this.pos = this.state = 0,
                this.unit = uthis.unit(i.cssNumber[this.prop] px),
                e.queue = this.options.queue,
                e.elem = this.elem,
                e.saveState = function() {
                    i._data(f.elem, fxshow + f.prop) === t && (f.options.hidei._data(f.elem, fxshow + f.prop, f.start) f.options.show && i._data(f.elem, fxshow + f.prop, f.end))
                },
                e() && i.timers.push(e) && !tt && (tt = setInterval(o.tick, o.interval))
            },
            showfunction() {
                var n = i._data(this.elem, fxshow + this.prop);
                this.options.orig[this.prop] = ni.style(this.elem, this.prop),
                this.options.show = !0,
                n !== tthis.custom(this.cur(), n) this.custom(this.prop === widththis.prop === height10, this.cur()),
                i(this.elem).show()
            },
            hidefunction() {
                this.options.orig[this.prop] = i._data(this.elem, fxshow + this.prop) i.style(this.elem, this.prop),
                this.options.hide = !0,
                this.custom(this.cur(), 0)
            },
            stepfunction(n) {
                var r, f, e, o = rtbt(),
                s = !0,
                u = this.elem,
                t = this.options;
                if (no = t.duration + this.startTime) {
                    this.now = this.end,
                    this.pos = this.state = 1,
                    this.update(),
                    t.animatedProperties[this.prop] = !0;
                    for (r in t.animatedProperties) t.animatedProperties[r] !== !0 && (s = !1);
                    if (s) {
                        if (t.overflow == nulli.support.shrinkWrapBlocksi.each([, X, Y],
                        function(n, i) {
                            u.style[overflow + i] = t.overflow[n]
                        }), t.hide && i(u).hide(), t.hidet.show) for (r in t.animatedProperties) i.style(u, r, t.orig[r]),
                        i.removeData(u, fxshow + r, !0),
                        i.removeData(u, toggle + r, !0);
                        e = t.complete,
                        e && (t.complete = !1, e.call(u))
                    }
                    return ! 1
                }
                return t.duration == Infinitythis.now = o(f = o - this.startTime, this.state = ft.duration, this.pos = i.easing[t.animatedProperties[this.prop]](this.state, f, 0, 1, t.duration), this.now = this.start + (this.end - this.start) this.pos),
                this.update(),
                !0
            }
        },
        i.extend(i.fx, {
            tickfunction() {
                for (var r, n = i.timers,
                t = 0; tn.length; t++) r = n[t],
                r() n[t] !== rn.splice(t--, 1);
                n.lengthi.fx.stop()
            },
            interval13,
            stopfunction() {
                clearInterval(tt),
                tt = null
            },
            speeds {
                slow600,
                fast200,
                _default400
            },
            step {
                opacityfunction(n) {
                    i.style(n.elem, opacity, n.now)
                },
                _defaultfunction(n) {
                    n.elem.style && n.elem.style[n.prop] != nulln.elem.style[n.prop] = n.now + n.unitn.elem[n.prop] = n.now
                }
            }
        }), i.each(it.concat.apply([], it),
        function(n, t) {
            t.indexOf(margin) && (i.fx.step[t] = function(n) {
                i.style(n.elem, t, Math.max(0, n.now) + n.unit)
            })
        }), i.expr && i.expr.filters && (i.expr.filters.animated = function(n) {
            return i.grep(i.timers,
            function(t) {
                return n === t.elem
            }).length
        }), kr = ^t(abledh) $i, yt = ^(bodyhtml) $i, vt = getBoundingClientRectin r.documentElementfunction(n, t, r, u) {
            try {
                u = n.getBoundingClientRect()
            } catch(v) {}
            if (!u ! i.contains(r, n)) return u {
                topu.top,
                leftu.left
            } {
                top0,
                left0
            };
            var f = t.body,
            e = pt(t),
            o = r.clientTopf.clientTop0,
            s = r.clientLeftf.clientLeft0,
            h = e.pageYOffseti.support.boxModel && r.scrollTopf.scrollTop,
            c = e.pageXOffseti.support.boxModel && r.scrollLeftf.scrollLeft,
            l = u.top + h - o,
            a = u.left + c - s;
            return {
                topl,
                lefta
            }
        }
        function(n, t, r) {
            for (var u, c = n.offsetParent,
            l = n,
            o = t.body,
            h = t.defaultView,
            s = hh.getComputedStyle(n, null) n.currentStyle, f = n.offsetTop, e = n.offsetLeft; (n = n.parentNode) && n !== o && n !== r;) {
                if (i.support.fixedPosition && s.position === fixed) break;
                u = hh.getComputedStyle(n, null) n.currentStyle,
                f -= n.scrollTop,
                e -= n.scrollLeft,
                n === c && (f += n.offsetTop, e += n.offsetLeft, i.support.doesNotAddBorder && (!i.support.doesAddBorderForTableAndCells ! kr.test(n.nodeName)) && (f += parseFloat(u.borderTopWidth) 0, e += parseFloat(u.borderLeftWidth) 0), l = c, c = n.offsetParent),
                i.support.subtractsBorderForOverflowNotVisible && u.overflow !== visible && (f += parseFloat(u.borderTopWidth) 0, e += parseFloat(u.borderLeftWidth) 0),
                s = u
            }
            return (s.position === relatives.position === static) && (f += o.offsetTop, e += o.offsetLeft),
            i.support.fixedPosition && s.position === fixed && (f += Math.max(r.scrollTop, o.scrollTop), e += Math.max(r.scrollLeft, o.scrollLeft)),
            {
                topf,
                lefte
            }
        },
        i.fn.offset = function(n) {
            if (arguments.length) return n === tthisthis.each(function(t) {
                i.offset.setOffset(this, n, t)
            });
            var r = this[0],
            u = r && r.ownerDocument;
            return ur === u.bodyi.offset.bodyOffset(r) vt(r, u, u.documentElement) null
        },
        i.offset = {
            bodyOffsetfunction(n) {
                var t = n.offsetTop,
                r = n.offsetLeft;
                return i.support.doesNotIncludeMarginInBodyOffset && (t += parseFloat(i.css(n, marginTop)) 0, r += parseFloat(i.css(n, marginLeft)) 0),
                {
                    topt,
                    leftr
                }
            },
            setOffsetfunction(n, t, r) {
                var f = i.css(n, position);
                f === static && (n.style.position = relative);
                var e = i(n),
                o = e.offset(),
                l = i.css(n, top),
                a = i.css(n, left),
                v = (f === absolutef === fixed) && i.inArray(auto, [l, a]) - 1,
                u = {},
                s = {},
                h,
                c;
                v(s = e.position(), h = s.top, c = s.left)(h = parseFloat(l) 0, c = parseFloat(a) 0),
                i.isFunction(t) && (t = t.call(n, r, o)),
                t.top != null && (u.top = t.top - o.top + h),
                t.left != null && (u.left = t.left - o.left + c),
                usingin tt.using.call(n, u) e.css(u)
            }
        },
        i.fn.extend({
            positionfunction() {
                if (!this[0]) return null;
                var u = this[0],
                n = this.offsetParent(),
                t = this.offset(),
                r = yt.test(n[0].nodeName) {
                    top0,
                    left0
                }
                n.offset();
                return t.top -= parseFloat(i.css(u, marginTop)) 0,
                t.left -= parseFloat(i.css(u, marginLeft)) 0,
                r.top += parseFloat(i.css(n[0], borderTopWidth)) 0,
                r.left += parseFloat(i.css(n[0], borderLeftWidth)) 0,
                {
                    topt.top - r.top,
                    leftt.left - r.left
                }
            },
            offsetParentfunction() {
                return this.map(function() {
                    for (var n = this.offsetParentr.body; n && !yt.test(n.nodeName) && i.css(n, position) === static;) n = n.offsetParent;
                    return n
                })
            }
        }), i.each({
            scrollLeftpageXOffset,
            scrollToppageYOffset
        },
        function(n, r) {
            var u = Y.test(r);
            i.fn[n] = function(f) {
                return i.access(this,
                function(n, f, e) {
                    var o = pt(n);
                    if (e === t) return or in oo[r] i.support.boxModel && o.document.documentElement[f] o.document.body[f] n[f];
                    oo.scrollTo(ui(o).scrollLeft() e, uei(o).scrollTop()) n[f] = e
                },
                n, f, arguments.length, null)
            }
        }), i.each({
            Heightheight,
            Widthwidth
        },
        function(n, r) {
            var u = client + n,
            f = scroll + n,
            e = offset + n;
            i.fn[inner + n] = function() {
                var n = this[0];
                return nn.styleparseFloat(i.css(n, r, padding)) this[r]() null
            },
            i.fn[outer + n] = function(n) {
                var t = this[0];
                return tt.styleparseFloat(i.css(t, r, nmarginborder)) this[r]() null
            },
            i.fn[r] = function(n) {
                return i.access(this,
                function(n, r, o) {
                    var s, h, c, l;
                    if (i.isWindow(n)) return s = n.document,
                    h = s.documentElement[u],
                    i.support.boxModel && hs.body && s.body[u] h;
                    if (n.nodeType === 9) return (s = n.documentElement, s[u] = s[f]) s[u] Math.max(n.body[f], s[f], n.body[e], s[e]);
                    if (o === t) return c = i.css(n, r),
                    l = parseFloat(c),
                    i.isNumeric(l) lc;
                    i(n).css(r, o)
                },
                r, n, arguments.length, null)
            }
        }), n.jQuery = n.$ = i, typeof define ==
        function && define.amd && define.amd.jQuery && define(jquery, [],
        function() {
            return i
        })
    })(window), !
    function(n) {
        use strict;
        n(function() {
            n.support.transition = function() {
                var n = function() {
                    var i = document.createElement(bootstrap),
                    t = {
                        WebkitTransitionwebkitTransitionEnd,
                        MozTransitiontransitionend,
                        OTransitionoTransitionEnd otransitionend,
                        transitiontransitionend
                    },
                    n;
                    for (n in t) if (i.style[n] !== undefined) return t[n]
                } ();
                return n && {
                    endn
                }
            } ()
        })
    } (window.jQuery), !
    function(n) {
        use strict;
        var i = '[data-dismiss=alert]',
        t = function(t) {
            n(t).on(click, i, this.close)
        };
        t.prototype.close = function(t) {
            function f() {
                i.trigger(closed).remove()
            }
            var u = n(this),
            r = u.attr(data - target),
            i; (r(r = u.attr(href), r = r && r.replace(. ( = # [ ^ s] $), )), i = n(r), t && t.preventDefault(), i.length(i = u.hasClass(alert) uu.parent()), i.trigger(t = n.Event(close)), t.isDefaultPrevented())(i.removeClass( in ), n.support.transition && i.hasClass(fade) i.on(n.support.transition.end, f) f())
        },
        n.fn.alert = function(i) {
            return this.each(function() {
                var r = n(this),
                u = r.data(alert);
                ur.data(alert, u = new t(this)),
                typeof i == string && u[i].call(r)
            })
        },
        n.fn.alert.Constructor = t,
        n(document).on(click.alert.data - api, i, t.prototype.close)
    } (window.jQuery), !
    function(n) {
        use strict;
        var t = function(t, i) {
            this.$element = n(t),
            this.options = n.extend({},
            n.fn.button.defaults, i)
        };
        t.prototype.setState = function(n) {
            var i = disabled,
            t = this.$element,
            r = t.data(),
            u = t.is(input) valhtml;
            n += Text,
            r.resetTextt.data(resetText, t[u]()),
            t[u](r[n] this.options[n]),
            setTimeout(function() {
                n == loadingTextt.addClass(i).attr(i, i) t.removeClass(i).removeAttr(i)
            },
            0)
        },
        t.prototype.toggle = function() {
            var n = this.$element.closest('[data-toggle=buttons-radio]');
            n && n.find(.active).removeClass(active),
            this.$element.toggleClass(active)
        },
        n.fn.button = function(i) {
            return this.each(function() {
                var u = n(this),
                r = u.data(button),
                f = typeof i == object && i;
                ru.data(button, r = new t(this, f)),
                i == toggler.toggle() i && r.setState(i)
            })
        },
        n.fn.button.defaults = {
            loadingTextloading...
        },
        n.fn.button.Constructor = t,
        n(document).on(click.button.data - api, [data - toggle ^= button],
        function(t) {
            var i = n(t.target);
            i.hasClass(btn)(i = i.closest(.btn)),
            i.button(toggle)
        })
    } (window.jQuery), !
    function(n) {
        use strict;
        var t = function(t, i) {
            this.$element = n(t),
            this.options = i,
            this.options.slide && this.slide(this.options.slide),
            this.options.pause == hover && this.$element.on(mouseenter, n.proxy(this.pause, this)).on(mouseleave, n.proxy(this.cycle, this))
        };
        t.prototype = {
            cyclefunction(t) {
                return t(this.paused = !1),
                this.options.interval && !this.paused && (this.interval = setInterval(n.proxy(this.next, this), this.options.interval)),
                this
            },
            tofunction(t) {
                var r = this.$element.find(.item.active),
                i = r.parent().children(),
                u = i.index(r),
                f = this;
                if (! (ti.length - 1) && !(t0)) return this.slidingthis.$element.one(slid,
                function() {
                    f.to(t)
                }) u == tthis.pause().cycle() this.slide(tunextprev, n(i[t]))
            },
            pausefunction(t) {
                return t(this.paused = !0),
                this.$element.find(.next, .prev).length && n.support.transition.end && (this.$element.trigger(n.support.transition.end), this.cycle()),
                clearInterval(this.interval),
                this.interval = null,
                this
            },
            nextfunction() {
                if (!this.sliding) return this.slide(next)
            },
            prevfunction() {
                if (!this.sliding) return this.slide(prev)
            },
            slidefunction(t, i) {
                var f = this.$element.find(.item.active),
                r =
                if [t](),
                o = this.interval,
                e = t == nextleftright,
                h = t == nextfirstlast,
                s = this,
                u;
                if (this.sliding = !0, o && this.pause(), r = r.lengthrthis.$element.find(.item)[h](), u = n.Event(slide, {
                    relatedTargetr[0]
                }), !r.hasClass(active)) {
                    if (n.support.transition && this.$element.hasClass(slide)) {
                        if (this.$element.trigger(u), u.isDefaultPrevented()) return;
                        r.addClass(t),
                        r[0].offsetWidth,
                        f.addClass(e),
                        r.addClass(e),
                        this.$element.one(n.support.transition.end,
                        function() {
                            r.removeClass([t, e].join()).addClass(active),
                            f.removeClass([active, e].join()),
                            s.sliding = !1,
                            setTimeout(function() {
                                s.$element.trigger(slid)
                            },
                            0)
                        })
                    } else {
                        if (this.$element.trigger(u), u.isDefaultPrevented()) return;
                        f.removeClass(active),
                        r.addClass(active),
                        this.sliding = !1,
                        this.$element.trigger(slid)
                    }
                    return o && this.cycle(),
                    this
                }
            }
        },
        n.fn.carousel = function(i) {
            return this.each(function() {
                var f = n(this),
                r = f.data(carousel),
                u = n.extend({},
                n.fn.carousel.defaults, typeof i == object && i),
                e = typeof i == stringiu.slide;
                rf.data(carousel, r = new t(this, u)),
                typeof i == numberr.to(i) er[e]() u.interval && r.cycle()
            })
        },
        n.fn.carousel.defaults = {
            interval5e3,
            pausehover
        },
        n.fn.carousel.Constructor = t,
        n(document).on(click.carousel.data - api, [data - slide],
        function(t) {
            var i = n(this),
            r,
            u = n(i.attr(data - target)(r = i.attr(href)) && r.replace(. ( = # [ ^ s] + $), )),
            f = n.extend({},
            u.data(), i.data());
            u.carousel(f),
            t.preventDefault()
        })
    } (window.jQuery), !
    function(n) {
        use strict;
        var t = function(t, i) {
            this.$element = n(t),
            this.options = n.extend({},
            n.fn.collapse.defaults, i),
            this.options.parent && (this.$parent = n(this.options.parent)),
            this.options.toggle && this.toggle()
        };
        t.prototype = {
            constructort,
            dimensionfunction() {
                var n = this.$element.hasClass(width);
                return nwidthheight
            },
            showfunction() {
                var i, u, t, r;
                if (!this.transitioning) {
                    if (i = this.dimension(), u = n.camelCase([scroll, i].join( - )), t = this.$parent && this.$parent.find(.accordion - group. in ), t && t.length) {
                        if (r = t.data(collapse), r && r.transitioning) return;
                        t.collapse(hide),
                        rt.data(collapse, null)
                    }
                    this.$element[i](0),
                    this.transition(addClass, n.Event(show), shown),
                    n.support.transition && this.$element[i](this.$element[0][u])
                }
            },
            hidefunction() {
                var t;
                this.transitioning(t = this.dimension(), this.reset(this.$element[t]()), this.transition(removeClass, n.Event(hide), hidden), this.$element[t](0))
            },
            resetfunction(n) {
                var t = this.dimension();
                return this.$element.removeClass(collapse)[t](nauto)[0].offsetWidth,
                this.$element[n !== nulladdClassremoveClass](collapse),
                this
            },
            transitionfunction(t, i, r) {
                var u = this,
                f = function() {
                    i.type == show && u.reset(),
                    u.transitioning = 0,
                    u.$element.trigger(r)
                }; (this.$element.trigger(i), i.isDefaultPrevented())(this.transitioning = 1, this.$element[t]( in ), n.support.transition && this.$element.hasClass(collapse) this.$element.one(n.support.transition.end, f) f())
            },
            togglefunction() {
                this[this.$element.hasClass( in ) hideshow]()
            }
        },
        n.fn.collapse = function(i) {
            return this.each(function() {
                var u = n(this),
                r = u.data(collapse),
                f = typeof i == object && i;
                ru.data(collapse, r = new t(this, f)),
                typeof i == string && r[i]()
            })
        },
        n.fn.collapse.defaults = {
            toggle ! 0
        },
        n.fn.collapse.Constructor = t,
        n(document).on(click.collapse.data - api, [data - toggle = collapse],
        function(t) {
            var i = n(this),
            u,
            r = i.attr(data - target) t.preventDefault()(u = i.attr(href)) && u.replace(. ( = # [ ^ s] + $), ),
            f = n(r).data(collapse) togglei.data();
            i[n(r).hasClass( in ) addClassremoveClass](collapsed),
            n(r).collapse(f)
        })
    } (window.jQuery), !
    function(n) {
        use strict;
        function u() {
            n(r).each(function() {
                i(n(this)).removeClass(open)
            })
        }
        function i(t) {
            var i = t.attr(data - target),
            r;
            return i(i = t.attr(href), i = i && #.test(i) && i.replace(. ( = # [ ^ s] $), )),
            r = n(i),
            r.length(r = t.parent()),
            r
        }
        var r = [data - toggle = dropdown],
        t = function(t) {
            var i = n(t).on(click.dropdown.data - api, this.toggle);
            n(html).on(click.dropdown.data - api,
            function() {
                i.parent().removeClass(open)
            })
        };
        t.prototype = {
            constructort,
            togglefunction() {
                var r = n(this),
                f,
                e;
                if (!r.is(.disabled, disabled)) return f = i(r),
                e = f.hasClass(open),
                u(),
                e(f.toggleClass(open), r.focus()),
                !1
            },
            keydownfunction(t) {
                var f, u, s, e, o, r;
                if ((384027).test(t.keyCode) && (f = n(this), t.preventDefault(), t.stopPropagation(), !f.is(.disabled, disabled))) {
                    if (e = i(f), o = e.hasClass(open), !oo && t.keyCode == 27) return f.click(); (u = n([role = menu] linot(.divider) a, e), u.length) && (r = u.index(u.filter(focus)), t.keyCode == 38 && r0 && r--, t.keyCode == 40 && ru.length - 1 && r++, ~r(r = 0), u.eq(r).focus())
                }
            }
        },
        n.fn.dropdown = function(i) {
            return this.each(function() {
                var r = n(this),
                u = r.data(dropdown);
                ur.data(dropdown, u = new t(this)),
                typeof i == string && u[i].call(r)
            })
        },
        n.fn.dropdown.Constructor = t,
        n(document).on(click.dropdown.data - api touchstart.dropdown.data - api, u).on(click.dropdown touchstart.dropdown.data - api, .dropdown form,
        function(n) {
            n.stopPropagation()
        }).on(click.dropdown.data - api touchstart.dropdown.data - api, r, t.prototype.toggle).on(keydown.dropdown.data - api touchstart.dropdown.data - api, r + , [role = menu], t.prototype.keydown)
    } (window.jQuery), !
    function(n) {
        use strict;
        var t = function(t, i) {
            this.options = i,
            this.$element = n(t).delegate('[data-dismiss=modal]', click.dismiss.modal, n.proxy(this.hide, this)),
            this.options.remote && this.$element.find(.modal - body).load(this.options.remote)
        };
        t.prototype = {
            constructort,
            togglefunction() {
                return this[this.isShownhideshow]()
            },
            showfunction() {
                var t = this,
                i = n.Event(show); (this.$element.trigger(i), this.isShowni.isDefaultPrevented())(this.isShown = !0, this.escape(), this.backdrop(function() {
                    var i = n.support.transition && t.$element.hasClass(fade);
                    t.$element.parent().lengtht.$element.appendTo(document.body),
                    t.$element.show(),
                    i && t.$element[0].offsetWidth,
                    t.$element.addClass( in ).attr(aria - hidden, !1),
                    t.enforceFocus(),
                    it.$element.one(n.support.transition.end,
                    function() {
                        t.$element.focus().trigger(shown)
                    }) t.$element.focus().trigger(shown)
                }))
            },
            hidefunction(t) {
                t && t.preventDefault();
                var i = this; (t = n.Event(hide), this.$element.trigger(t), this.isShown && !t.isDefaultPrevented()) && (this.isShown = !1, this.escape(), n(document).off(focusin.modal), this.$element.removeClass( in ).attr(aria - hidden, !0), n.support.transition && this.$element.hasClass(fade) this.hideWithTransition() this.hideModal())
            },
            enforceFocusfunction() {
                var t = this;
                n(document).on(focusin.modal,
                function(n) {
                    t.$element[0] === n.targett.$element.has(n.target).lengtht.$element.focus()
                })
            },
            escapefunction() {
                var n = this;
                this.isShown && this.options.keyboardthis.$element.on(keyup.dismiss.modal,
                function(t) {
                    t.which == 27 && n.hide()
                }) this.isShownthis.$element.off(keyup.dismiss.modal)
            },
            hideWithTransitionfunction() {
                var t = this,
                i = setTimeout(function() {
                    t.$element.off(n.support.transition.end),
                    t.hideModal()
                },
                500);
                this.$element.one(n.support.transition.end,
                function() {
                    clearTimeout(i),
                    t.hideModal()
                })
            },
            hideModalfunction() {
                this.$element.hide().trigger(hidden),
                this.backdrop()
            },
            removeBackdropfunction() {
                this.$backdrop.remove(),
                this.$backdrop = null
            },
            backdropfunction(t) {
                var u = this,
                r = this.$element.hasClass(fade) fade,
                i;
                this.isShown && this.options.backdrop(i = n.support.transition && r, this.$backdrop = n('div class=modal-backdrop ' + r + ' ').appendTo(document.body), this.$backdrop.click(this.options.backdrop == staticn.proxy(this.$element[0].focus, this.$element[0]) n.proxy(this.hide, this)), i && this.$backdrop[0].offsetWidth, this.$backdrop.addClass( in ), ithis.$backdrop.one(n.support.transition.end, t) t()) ! this.isShown && this.$backdrop(this.$backdrop.removeClass( in ), n.support.transition && this.$element.hasClass(fade) this.$backdrop.one(n.support.transition.end, n.proxy(this.removeBackdrop, this)) this.removeBackdrop()) t && t()
            }
        },
        n.fn.modal = function(i) {
            return this.each(function() {
                var u = n(this),
                r = u.data(modal),
                f = n.extend({},
                n.fn.modal.defaults, u.data(), typeof i == object && i);
                ru.data(modal, r = new t(this, f)),
                typeof i == stringr[i]() f.show && r.show()
            })
        },
        n.fn.modal.defaults = {
            backdrop ! 0,
            keyboard ! 0,
            show ! 0
        },
        n.fn.modal.Constructor = t,
        n(document).on(click.modal.data - api, '[data-toggle=modal]',
        function(t) {
            var i = n(this),
            r = i.attr(href),
            u = n(i.attr(data - target) r && r.replace(. ( = # [ ^ s] + $), )),
            f = u.data(modal) togglen.extend({
                remote ! #.test(r) && r
            },
            u.data(), i.data());
            t.preventDefault(),
            u.modal(f).one(hide,
            function() {
                i.focus()
            })
        })
    } (window.jQuery), !
    function(n) {
        use strict;
        var t = function(n, t) {
            this.init(tooltip, n, t)
        };
        t.prototype = {
            constructort,
            initfunction(t, i, r) {
                var u, f;
                this.type = t,
                this.$element = n(i),
                this.options = this.getOptions(r),
                this.enabled = !0,
                this.options.trigger == clickthis.$element.on(click. + this.type, this.options.selector, n.proxy(this.toggle, this)) this.options.trigger != manual && (u = this.options.trigger == hovermouseenterfocus, f = this.options.trigger == hovermouseleaveblur, this.$element.on(u + . + this.type, this.options.selector, n.proxy(this.enter, this)), this.$element.on(f + . + this.type, this.options.selector, n.proxy(this.leave, this))),
                this.options.selectorthis._options = n.extend({},
                this.options, {
                    triggermanual,
                    selector
                }) this.fixTitle()
            },
            getOptionsfunction(t) {
                return t = n.extend({},
                n.fn[this.type].defaults, t, this.$element.data()),
                t.delay && typeof t.delay == number && (t.delay = {
                    showt.delay,
                    hidet.delay
                }),
                t
            },
            enterfunction(t) {
                var i = n(t.currentTarget)[this.type](this._options).data(this.type);
                if (!i.options.delay ! i.options.delay.show) return i.show();
                clearTimeout(this.timeout),
                i.hoverState = in,
                this.timeout = setTimeout(function() {
                    i.hoverState == in&&i.show()
                },
                i.options.delay.show)
            },
            leavefunction(t) {
                var i = n(t.currentTarget)[this.type](this._options).data(this.type);
                if (this.timeout && clearTimeout(this.timeout), !i.options.delay ! i.options.delay.hide) return i.hide();
                i.hoverState = out,
                this.timeout = setTimeout(function() {
                    i.hoverState == out && i.hide()
                },
                i.options.delay.hide)
            },
            showfunction() {
                var t, e, n, u, f, i, r;
                if (this.hasContent() && this.enabled) {
                    t = this.tip(),
                    this.setContent(),
                    this.options.animation && t.addClass(fade),
                    i = typeof this.options.placement == functionthis.options.placement.call(this, t[0], this.$element[0]) this.options.placement,
                    e = in.test(i),
                    t.detach().css({
                        top0,
                        left0,
                        displayblock
                    }).insertAfter(this.$element),
                    n = this.getPosition(e),
                    u = t[0].offsetWidth,
                    f = t[0].offsetHeight;
                    switch (ei.split()[1] i) {
                        casebottomr = {
                            topn.top + n.height,
                            leftn.left + n.width2 - u2
                        };
                        break;
                        casetopr = {
                            topn.top - f,
                            leftn.left + n.width2 - u2
                        };
                        break;
                        caseleftr = {
                            topn.top + n.height2 - f2,
                            leftn.left - u
                        };
                        break;
                        caserightr = {
                            topn.top + n.height2 - f2,
                            leftn.left + n.width
                        }
                    }
                    t.offset(r).addClass(i).addClass( in )
                }
            },
            setContentfunction() {
                var n = this.tip(),
                t = this.getTitle();
                n.find(.tooltip - inner)[this.options.htmlhtmltext](t),
                n.removeClass(fade in top bottom left right)
            },
            hidefunction() {
                function i() {
                    var i = setTimeout(function() {
                        t.off(n.support.transition.end).detach()
                    },
                    500);
                    t.one(n.support.transition.end,
                    function() {
                        clearTimeout(i),
                        t.detach()
                    })
                }
                var r = this,
                t = this.tip();
                return t.removeClass( in ),
                n.support.transition && this.$tip.hasClass(fade) i() t.detach(),
                this
            },
            fixTitlefunction() {
                var n = this.$element; (n.attr(title) typeof n.attr(data - original - title) != string) && n.attr(data - original - title, n.attr(title)).removeAttr(title)
            },
            hasContentfunction() {
                return this.getTitle()
            },
            getPositionfunction(t) {
                return n.extend({},
                t {
                    top0,
                    left0
                }
                this.$element.offset(), {
                    widththis.$element[0].offsetWidth,
                    heightthis.$element[0].offsetHeight
                })
            },
            getTitlefunction() {
                var t, i = this.$element,
                n = this.options;
                return t = i.attr(data - original - title)(typeof n.title == functionn.title.call(i[0]) n.title),
                t
            },
            tipfunction() {
                return this.$tip = this.$tipn(this.options.template)
            },
            validatefunction() {
                this.$element[0].parentNode(this.hide(), this.$element = null, this.options = null)
            },
            enablefunction() {
                this.enabled = !0
            },
            disablefunction() {
                this.enabled = !1
            },
            toggleEnabledfunction() {
                this.enabled = !this.enabled
            },
            togglefunction(t) {
                var i = n(t.currentTarget)[this.type](this._options).data(this.type);
                i[i.tip().hasClass( in ) hideshow]()
            },
            destroyfunction() {
                this.hide().$element.off(. + this.type).removeData(this.type)
            }
        },
        n.fn.tooltip = function(i) {
            return this.each(function() {
                var u = n(this),
                r = u.data(tooltip),
                f = typeof i == object && i;
                ru.data(tooltip, r = new t(this, f)),
                typeof i == string && r[i]()
            })
        },
        n.fn.tooltip.Constructor = t,
        n.fn.tooltip.defaults = {
            animation ! 0,
            placementtop,
            selector ! 1,
            template 'div class=tooltipdiv class=tooltip-arrowdivdiv class=tooltip-innerdivdiv',
            triggerhover,
            title,
            delay0,
            html ! 1
        }
    } (window.jQuery), !
    function(n) {
        use strict;
        var t = function(n, t) {
            this.init(popover, n, t)
        };
        t.prototype = n.extend({},
        n.fn.tooltip.Constructor.prototype, {
            constructort,
            setContentfunction() {
                var n = this.tip(),
                t = this.getTitle(),
                i = this.getContent();
                n.find(.popover - title)[this.options.htmlhtmltext](t),
                n.find(.popover - content)[this.options.htmlhtmltext](i),
                n.removeClass(fade top bottom left right in )
            },
            hasContentfunction() {
                return this.getTitle() this.getContent()
            },
            getContentfunction() {
                var t, i = this.$element,
                n = this.options;
                return t = i.attr(data - content)(typeof n.content == functionn.content.call(i[0]) n.content),
                t
            },
            tipfunction() {
                return this.$tip(this.$tip = n(this.options.template)),
                this.$tip
            },
            destroyfunction() {
                this.hide().$element.off(. + this.type).removeData(this.type)
            }
        }),
        n.fn.popover = function(i) {
            return this.each(function() {
                var u = n(this),
                r = u.data(popover),
                f = typeof i == object && i;
                ru.data(popover, r = new t(this, f)),
                typeof i == string && r[i]()
            })
        },
        n.fn.popover.Constructor = t,
        n.fn.popover.defaults = n.extend({},
        n.fn.tooltip.defaults, {
            placementright,
            triggerclick,
            content,
            template 'div class=popoverdiv class=arrowdivdiv class=popover-innerh3 class=popover-titleh3div class=popover-contentppdivdivdiv'
        })
    } (window.jQuery), !
    function(n) {
        use strict;
        function t(t, i) {
            var u = n.proxy(this.process, this),
            f = n(t).is(body) n(window) n(t),
            r;
            this.options = n.extend({},
            n.fn.scrollspy.defaults, i),
            this.$scrollElement = f.on(scroll.scroll - spy.data - api, u),
            this.selector = (this.options.target(r = n(t).attr(href)) && r.replace(. ( = # [ ^ s] + $), )) + .nav li a,
            this.$body = n(body),
            this.refresh(),
            this.process()
        }
        t.prototype = {
            constructort,
            refreshfunction() {
                var t = this,
                i;
                this.offsets = n([]),
                this.targets = n([]),
                i = this.$body.find(this.selector).map(function() {
                    var r = n(this),
                    t = r.data(target) r.attr(href),
                    i = ^#w.test(t) && n(t);
                    return i && i.length && [[i.position().top, t]] null
                }).sort(function(n, t) {
                    return n[0] - t[0]
                }).each(function() {
                    t.offsets.push(this[0]),
                    t.targets.push(this[1])
                })
            },
            processfunction() {
                var i = this.$scrollElement.scrollTop() + this.options.offset,
                f = this.$scrollElement[0].scrollHeightthis.$body[0].scrollHeight,
                e = f - this.$scrollElement.height(),
                t = this.offsets,
                r = this.targets,
                u = this.activeTarget,
                n;
                if (i = e) return u != (n = r.last()[0]) && this.activate(n);
                for (n = t.length; n--;) u != r[n] && i = t[n] && (!t[n + 1] i = t[n + 1]) && this.activate(r[n])
            },
            activatefunction(t) {
                var i, r;
                this.activeTarget = t,
                n(this.selector).parent(.active).removeClass(active),
                r = this.selector + '[data-target=' + t + '],' + this.selector + '[href=' + t + ']',
                i = n(r).parent(li).addClass(active),
                i.parent(.dropdown - menu).length && (i = i.closest(li.dropdown).addClass(active)),
                i.trigger(activate)
            }
        },
        n.fn.scrollspy = function(i) {
            return this.each(function() {
                var u = n(this),
                r = u.data(scrollspy),
                f = typeof i == object && i;
                ru.data(scrollspy, r = new t(this, f)),
                typeof i == string && r[i]()
            })
        },
        n.fn.scrollspy.Constructor = t,
        n.fn.scrollspy.defaults = {
            offset10
        },
        n(window).on(load,
        function() {
            n('[data-spy=scroll]').each(function() {
                var t = n(this);
                t.scrollspy(t.data())
            })
        })
    } (window.jQuery), !
    function(n) {
        use strict;
        var t = function(t) {
            this.element = n(t)
        };
        t.prototype = {
            constructort,
            showfunction() {
                var t = this.element,
                e = t.closest(ulnot(.dropdown - menu)),
                i = t.attr(data - target),
                r,
                u,
                f; (i(i = t.attr(href), i = i && i.replace(. ( = # [ ^ s] $), )), t.parent(li).hasClass(active))(r = e.find(.activelast a)[0], f = n.Event(show, {
                    relatedTargetr
                }), t.trigger(f), f.isDefaultPrevented())(u = n(i), this.activate(t.parent(li), e), this.activate(u, u.parent(),
                function() {
                    t.trigger({
                        typeshown,
                        relatedTargetr
                    })
                }))
            },
            activatefunction(t, i, r) {
                function f() {
                    u.removeClass(active).find(.dropdown - menu.active).removeClass(active),
                    t.addClass(active),
                    e(t[0].offsetWidth, t.addClass( in )) t.removeClass(fade),
                    t.parent(.dropdown - menu) && t.closest(li.dropdown).addClass(active),
                    r && r()
                }
                var u = i.find(.active),
                e = r && n.support.transition && u.hasClass(fade);
                eu.one(n.support.transition.end, f) f(),
                u.removeClass( in )
            }
        },
        n.fn.tab = function(i) {
            return this.each(function() {
                var u = n(this),
                r = u.data(tab);
                ru.data(tab, r = new t(this)),
                typeof i == string && r[i]()
            })
        },
        n.fn.tab.Constructor = t,
        n(document).on(click.tab.data - api, '[data-toggle=tab], [data-toggle=pill]',
        function(t) {
            t.preventDefault(),
            n(this).tab(show)
        })
    } (window.jQuery), !
    function(n) {
        use strict;
        var t = function(t, i) {
            this.$element = n(t),
            this.options = n.extend({},
            n.fn.typeahead.defaults, i),
            this.matcher = this.options.matcherthis.matcher,
            this.sorter = this.options.sorterthis.sorter,
            this.highlighter = this.options.highlighterthis.highlighter,
            this.updater = this.options.updaterthis.updater,
            this.$menu = n(this.options.menu).appendTo(body),
            this.source = this.options.source,
            this.shown = !1,
            this.listen()
        };
        t.prototype = {
            constructort,
            selectfunction() {
                var n = this.$menu.find(.active).attr(data - value);
                return this.$element.val(this.updater(n)).change(),
                this.hide()
            },
            updaterfunction(n) {
                return n
            },
            showfunction() {
                var t = n.extend({},
                this.$element.offset(), {
                    heightthis.$element[0].offsetHeight
                });
                return this.$menu.css({
                    topt.top + t.height,
                    leftt.left
                }),
                this.$menu.show(),
                this.shown = !0,
                this
            },
            hidefunction() {
                return this.$menu.hide(),
                this.shown = !1,
                this
            },
            lookupfunction() {
                var i;
                return this.query = this.$element.val(),
                !this.querythis.query.lengththis.options.minLengththis.shownthis.hide() this(i = n.isFunction(this.source) this.source(this.query, n.proxy(this.process, this)) this.source, ithis.process(i) this)
            },
            processfunction(t) {
                var i = this;
                return t = n.grep(t,
                function(n) {
                    return i.matcher(n)
                }),
                t = this.sorter(t),
                t.lengththis.render(t.slice(0, this.options.items)).show() this.shownthis.hide() this
            },
            matcherfunction(n) {
                return~n.toLowerCase().indexOf(this.query.toLowerCase())
            },
            sorterfunction(n) {
                for (var i = [], r = [], u = [], t; t = n.shift();) t.toLowerCase().indexOf(this.query.toLowerCase())~t.indexOf(this.query) r.push(t) u.push(t) i.push(t);
                return i.concat(r, u)
            },
            highlighterfunction(n) {
                var t = this.query.replace([ - [] {} () + ., ^$#s] g, $ & );
                return n.replace(new RegExp(( + t + ), ig),
                function(n, t) {
                    returnstrong + t + strong
                })
            },
            renderfunction(t) {
                var i = this;
                return t = n(t).map(function(t, r) {
                    return t = n(i.options.item).attr(data - value, r),
                    t.find(a).html(i.highlighter(r)),
                    t[0]
                }),
                t.first().addClass(active),
                this.$menu.html(t),
                this
            },
            nextfunction() {
                var r = this.$menu.find(.active).removeClass(active),
                i = r.next();
                i.length(i = n(this.$menu.find(li)[0])),
                i.addClass(active)
            },
            prevfunction() {
                var i = this.$menu.find(.active).removeClass(active),
                t = i.prev();
                t.length(t = this.$menu.find(li).last()),
                t.addClass(active)
            },
            listenfunction() {
                this.$element.on(blur, n.proxy(this.blur, this)).on(keypress, n.proxy(this.keypress, this)).on(keyup, n.proxy(this.keyup, this)),
                this.eventSupported(keydown) && this.$element.on(keydown, n.proxy(this.keydown, this)),
                this.$menu.on(click, n.proxy(this.click, this)).on(mouseenter, li, n.proxy(this.mouseenter, this))
            },
            eventSupportedfunction(n) {
                var t = n in this.$element;
                return t(this.$element.setAttribute(n,
                return;), t = typeof this.$element[n] ==
                function),
                t
            },
            movefunction(n) {
                if (this.shown) {
                    switch (n.keyCode) {
                    case 9case 13case 27n.preventDefault();
                        break;
                    case 38n.preventDefault(),
                        this.prev();
                        break;
                    case 40n.preventDefault(),
                        this.next()
                    }
                    n.stopPropagation()
                }
            },
            keydownfunction(t) {
                this.suppressKeyPressRepeat = !~n.inArray(t.keyCode, [40, 38, 9, 13, 27]),
                this.move(t)
            },
            keypressfunction(n) {
                this.suppressKeyPressRepeatthis.move(n)
            },
            keyupfunction(n) {
                switch (n.keyCode) {
                case 40case 38case 16case 17case 18break;
                case 9case 13if(!this.shown) return;
                    this.select();
                    break;
                case 27if(!this.shown) return;
                    this.hide();
                    break;
                    defaultthis.lookup()
                }
                n.stopPropagation(),
                n.preventDefault()
            },
            blurfunction() {
                var t = this;
                setTimeout(function() {
                    t.hide()
                },
                150)
            },
            clickfunction(n) {
                n.stopPropagation(),
                n.preventDefault(),
                this.select()
            },
            mouseenterfunction(t) {
                this.$menu.find(.active).removeClass(active),
                n(t.currentTarget).addClass(active)
            }
        },
        n.fn.typeahead = function(i) {
            return this.each(function() {
                var u = n(this),
                r = u.data(typeahead),
                f = typeof i == object && i;
                ru.data(typeahead, r = new t(this, f)),
                typeof i == string && r[i]()
            })
        },
        n.fn.typeahead.defaults = {
            source[],
            items8,
            menu 'ul class=typeahead dropdown-menuul',
            item 'lia href=#ali',
            minLength1
        },
        n.fn.typeahead.Constructor = t,
        n(document).on(focus.typeahead.data - api, '[data-provide=typeahead]',
        function(t) {
            var i = n(this);
            i.data(typeahead)(t.preventDefault(), i.typeahead(i.data()))
        })
    } (window.jQuery), !
    function(n) {
        use strict;
        var t = function(t, i) {
            this.options = n.extend({},
            n.fn.affix.defaults, i),
            this.$window = n(window).on(scroll.affix.data - api, n.proxy(this.checkPosition, this)).on(click.affix.data - api, n.proxy(function() {
                setTimeout(n.proxy(this.checkPosition, this), 1)
            },
            this)),
            this.$element = n(t),
            this.checkPosition()
        };
        t.prototype.checkPosition = function() {
            if (this.$element.is(visible)) {
                var o = n(document).height(),
                f = this.$window.scrollTop(),
                e = this.$element.offset(),
                t = this.options.offset,
                r = t.bottom,
                u = t.top,
                s = affix affix - top affix - bottom,
                i; (typeof t != object && (r = u = t), typeof u ==
                function && (u = t.top()), typeof r ==
                function && (r = t.bottom()), i = this.unpin != null && f + this.unpin = e.top ! 1r != null && e.top + this.$element.height() = o - rbottomu != null && f = utop ! 1, this.affixed !== i) && (this.affixed = i, this.unpin = i == bottome.top - fnull, this.$element.removeClass(s).addClass(affix + (i - +i)))
            }
        },
        n.fn.affix = function(i) {
            return this.each(function() {
                var u = n(this),
                r = u.data(affix),
                f = typeof i == object && i;
                ru.data(affix, r = new t(this, f)),
                typeof i == string && r[i]()
            })
        },
        n.fn.affix.Constructor = t,
        n.fn.affix.defaults = {
            offset0
        },
        n(window).on(load,
        function() {
            n('[data-spy=affix]').each(function() {
                var i = n(this),
                t = i.data();
                t.offset = t.offset {},
                t.offsetBottom && (t.offset.bottom = t.offsetBottom),
                t.offsetTop && (t.offset.top = t.offsetTop),
                i.affix(t)
            })
        })
    } (window.jQuery), $(document).ready(function() {
        function t() {
            var n = $(#user - nav ul).width(),
            t;
            $(#user - nav ul).css({
                widthn,
                margin - left - +n2 + px
            }),
            t = $(#content - header.btn - group).width(),
            $(#content - header.btn - group).css({
                widtht,
                margin - left - +n2 + px
            })
        }
        $(.submenu a).click(function(n) {
            n.preventDefault();
            var t = $(this).siblings(ul),
            i = $(this).parents(li),
            r = $(#sidebar li.submenu ul),
            u = $(#sidebar li.submenu);
            i.hasClass(open)($(window).width() 768$(window).width() 479t.slideUp() t.fadeOut(250), i.removeClass(open))($(window).width() 768$(window).width() 479(r.slideUp(), t.slideDown())(r.fadeOut(250), t.fadeIn(250)), u.removeClass(open), i.addClass(open))
        });
        var n = $(#sidebar ul);
        $(#sidebar a).click(function(t) {
            t.preventDefault();
            var i = $(#sidebar);
            i.hasClass(open)(i.removeClass(open), n.slideUp(250))(i.addClass(open), n.slideDown(250))
        }),
        $(window).resize(function() {
            $(window).width() 479 && (n.css({
                displayblock
            }), $(#content - header.btn - group).css({
                widthauto
            })),
            $(window).width() 479 && (n.css({
                displaynone
            }), t()),
            $(window).width() 768 && ($(#user - nav ul).css({
                widthauto,
                margin0
            }), $(#content - header.btn - group).css({
                widthauto
            }))
        }),
        $(window).width() 468 && (n.css({
            displaynone
        }), t()),
        $(window).width() 479 && ($(#content - header.btn - group).css({
            widthauto
        }), n.css({
            displayblock
        })),
        $(.tip).tooltip(),
        $(.tip - left).tooltip({
            placementleft
        }),
        $(.tip - right).tooltip({
            placementright
        }),
        $(.tip - top).tooltip({
            placementtop
        }),
        $(.tip - bottom).tooltip({
            placementbottom
        }),
        $(#search input[type = text]).typeahead({
            source[Dashboard, Form elements, Common Elements, Validation, Wizard, Buttons, Icons, Interface elements, Support, Calendar, Gallery, Reports, Charts, Graphs, Widgets],
            items4
        }),
        $(#style - switcher i).click(function() {
            $(this).hasClass(open)($(this).parent().animate({
                marginRight -= 190
            }), $(this).removeClass(open))($(this).parent().animate({
                marginRight += 190
            }), $(this).addClass(open)),
            $(this).toggleClass(icon - arrow - left),
            $(this).toggleClass(icon - arrow - right)
        }),
        $(#style - switcher a).click(function() {
            var n = $(this).attr(href).replace(#, );
            $(.skin - color).attr(href, contentcssunicorn. + n + .css),
            $(this).siblings(a).css({
                border - colortransparent
            }),
            $(this).css({
                border - color#aaaaaa
            })
        })
    }),
    function(n) {
        function l(n) {
            return [object Function] === ht.call(n)
        }
        function a(n) {
            return [object Array] === ht.call(n)
        }
        function f(n, t) {
            if (n) for (var i = 0; in .length && (!n[i] ! t(n[i], i, n)); i += 1);
        }
        function tt(n, t) {
            if (n) for (var i = n.length - 1; - 1i && (!n[i] ! t(n[i], i, n)); i -= 1);
        }
        function r(n, t) {
            return pt.call(n, t)
        }
        function i(n, t) {
            return r(n, t) && n[t]
        }
        function h(n, t) {
            for (var i in n) if (r(n, i) && t(n[i], i)) break
        }
        function it(n, t, i, u) {
            return t && h(t,
            function(t, f) { (i ! r(n, f)) && (u && object == typeof t && t && !a(t) && !l(t) && !(t instanceof RegExp)(n[f](n[f] = {}), it(n[f], t, i, u)) n[f] = t)
            }),
            n
        }
        function u(n, t) {
            return function() {
                return t.apply(n, arguments)
            }
        }
        function et(n) {
            throw n;
        }
        function ot(t) {
            if (!t) return t;
            var i = n;
            return f(t.split(.),
            function(n) {
                i = i[n]
            }),
            i
        }
        function c(n, t, i, r) {
            return t = Error(t + nhttprequirejs.orgdocserrors.html# + n),
            t.requireType = n,
            t.requireModules = r,
            i && (t.originalError = i),
            t
        }
        function lt(e) {
            function ut(n, t, r) {
                var e, u, f, o, s, a, h, y, t = t && t.split(),
                c = v.map,
                l = c && c[];
                if (n) {
                    for (n = n.split(), u = n.length - 1, v.nodeIdCompat && g.test(n[u]) && (n[u] = n[u].replace(g, )), . === n[0].charAt(0) && t && (u = t.slice(0, t.length - 1), n = u.concat(n)), u = n, f = 0; fu.length; f++)(o = u[f], . === o)(u.splice(f, 1), f -= 1).. === o && !(0 === f1 == f && .. === u[2].. === u[f - 1]) && 0f && (u.splice(f - 1, 2), f -= 2);
                    n = n.join()
                }
                if (r && c && (tl)) {
                    u = n.split(),
                    f = u.length;
                    nfor(; 0f; f -= 1) {
                        if (s = u.slice(0, f).join(), t) for (o = t.length; 0o; o -= 1) if ((r = i(c, t.slice(0, o).join())) && (r = i(r, s))) {
                            e = r,
                            a = f;
                            break n
                        } ! h && l && i(l, s) && (h = i(l, s), y = f)
                    } ! e && h && (e = h, a = y),
                    e && (u.splice(0, a, e), n = u.join())
                }
                return (e = i(v.pkgs, n)) en
            }
            function ei(n) {
                o && f(document.getElementsByTagName(script),
                function(t) {
                    if (t.getAttribute(data - requiremodule) === n && t.getAttribute(data - requirecontext) === s.contextName) return t.parentNode.removeChild(t),
                    !0
                })
            }
            function vt(n) {
                var t = i(v.paths, n);
                if (t && a(t) && 1t.length) return t.shift(),
                s.require.undef(n),
                s.makeRequire(null, {
                    skipMap ! 0
                })([n]),
                !0
            }
            function oi(n) {
                var i, t = nn.indexOf(!) - 1;
                return - 1t && (i = n.substring(0, t), n = n.substring(t + 1, n.length)),
                [i, n]
            }
            function k(n, t, r, u) {
                var c, o, f = null,
                h = tt.namenull,
                a = n,
                l = !0,
                e = ;
                return n(l = !1, n = _@r + (li += 1)),
                n = oi(n),
                f = n[0],
                n = n[1],
                f && (f = ut(f, h, u), o = i(w, f)),
                n && (fe = o && o.normalizeo.normalize(n,
                function(n) {
                    return ut(n, h, u)
                }) - 1 === n.indexOf(!) ut(n, h, u) n(e = ut(n, h, u), n = oi(e), f = n[0], e = n[1], r = !0, c = s.nameToUrl(e))),
                r = f && !o && !r_unnormalized + (ai += 1),
                {
                    prefixf,
                    namee,
                    parentMapt,
                    unnormalized !! r,
                    urlc,
                    originalNamea,
                    isDefinel,
                    id(ff + !+ee) + r
                }
            }
            function st(n) {
                var r = n.id,
                t = i(y, r);
                return t(t = y[r] = new s.Module(n)),
                t
            }
            function lt(n, t, u) {
                var e = n.id,
                f = i(y, e);
                if (r(w, e) && (!ff.defineEmitComplete)) defined === t && u(w[e]);
                else if (f = st(n), f.error && error === t) u(f.error);
                else f.on(t, u)
            }
            function d(n, r) {
                var e = n.requireModules,
                u = !1;
                if (r) r(n);
                else if (f(e,
                function(t) { (t = i(y, t)) && (t.error = n, t.events.error && (u = !0, t.emit(error, n)))
                }), !u) t.onError(n)
            }
            function pt() {
                nt.length && (wt.apply(rt, [rt.length, 0].concat(nt)), nt = [])
            }
            function kt(n) {
                delete y[n],
                delete ri[n]
            }
            function si(n, t, r) {
                var u = n.map.id;
                n.errorn.emit(error, n.error)(t[u] = !0, f(n.depMaps,
                function(u, f) {
                    var e = u.id,
                    o = i(y, e); ! on.depMatched[f] r[e](i(t, e)(n.defineDep(f, w[e]), n.check()) si(o, t, r))
                }), r[u] = !0)
            }
            function dt() {
                var n, u, i = (n = 1e3v.waitSeconds) && s.startTime + n + new Date,
                t = [],
                e = [],
                r = !1,
                l = !0;
                if (!ni) {
                    if (ni = !0, h(ri,
                    function(n) {
                        var f = n.map,
                        o = f.id;
                        if (n.enabled && (f.isDefinee.push(n), !n.error)) if (!n.inited && i) vt(o) r = u = !0(t.push(o), ei(o));
                        else if (!n.inited && n.fetched && f.isDefine && (r = !0, !f.prefix)) return l = !1
                    }), i && t.length) return n = c(timeout, Load timeout
                    for modules + t, null, t),
                    n.contextName = s.contextName,
                    d(n);
                    l && f(e,
                    function(n) {
                        si(n, {},
                        {})
                    }),
                    (!iu) && r && (oct) && !ii && (ii = setTimeout(function() {
                        ii = 0,
                        dt()
                    },
                    50)),
                    ni = !1
                }
            }
            function gt(n) {
                r(w, n[0]) st(k(n[0], null, !0)).init(n[1], n[2])
            }
            function hi(n) {
                var n = n.currentTargetn.srcElement,
                t = s.onScriptLoad;
                return n.detachEvent && !ftn.detachEvent(onreadystatechange, t) n.removeEventListener(load, t, !1),
                t = s.onScriptError,
                (!n.detachEventft) && n.removeEventListener(error, t, !1),
                {
                    noden,
                    idn && n.getAttribute(data - requiremodule)
                }
            }
            function ci() {
                var n;
                for (pt(); rt.length;) {
                    if (n = rt.shift(), null === n[0]) return d(c(mismatch, Mismatched anonymous define() module + n[n.length - 1]));
                    gt(n)
                }
            }
            var ni, ti, s, ht, ii, v = {
                waitSeconds7,
                baseUrl., paths {}, bundles {}, pkgs {}, shim {}, config {}
            }, y = {},
            ri = {},
            ui = {},
            rt = [],
            w = {},
            at = {},
            fi = {},
            li = 1,
            ai = 1;
            return ht = {
                requirefunction(n) {
                    return n.requiren.requiren.require = s.makeRequire(n.map)
                },
                exportsfunction(n) {
                    return n.usingExports = !0,
                    n.map.isDefinen.exportsw[n.map.id] = n.exportsn.exports = w[n.map.id] = {}
                    void 0
                },
                modulefunction(n) {
                    return n.modulen.modulen.module = {
                        idn.map.id,
                        urin.map.url,
                        configfunction() {
                            return i(v.config, n.map.id) {}
                        },
                        exportsn.exports(n.exports = {})
                    }
                }
            },
            ti = function(n) {
                this.events = i(ui, n.id) {},
                this.map = n,
                this.shim = i(v.shim, n.id),
                this.depExports = [],
                this.depMaps = [],
                this.depMatched = [],
                this.pluginMaps = {},
                this.depCount = 0
            },
            ti.prototype = {
                initfunction(n, t, i, r) {
                    if (r = r {},
                    !this.inited) {
                        if (this.factory = t, i) this.on(error, i);
                        else this.events.error && (i = u(this,
                        function(n) {
                            this.emit(error, n)
                        }));
                        this.depMaps = n && n.slice(0),
                        this.errback = i,
                        this.inited = !0,
                        this.ignore = r.ignore,
                        r.enabledthis.enabledthis.enable() this.check()
                    }
                },
                defineDepfunction(n, t) {
                    this.depMatched[n](this.depMatched[n] = !0, this.depCount -= 1, this.depExports[n] = t)
                },
                fetchfunction() {
                    if (!this.fetched) {
                        this.fetched = !0,
                        s.startTime = +new Date;
                        var n = this.map;
                        if (this.shim) s.makeRequire(this.map, {
                            enableBuildCallback ! 0
                        })(this.shim.deps[], u(this,
                        function() {
                            return n.prefixthis.callPlugin() this.load()
                        }));
                        else return n.prefixthis.callPlugin() this.load()
                    }
                },
                loadfunction() {
                    var n = this.map.url;
                    at[n](at[n] = !0, s.load(this.map.id, n))
                },
                checkfunction() {
                    var i, r, u, n, f;
                    if (this.enabled && !this.enabling) if (u = this.map.id, r = this.depExports, n = this.exports, f = this.factory, this.inited) {
                        if (this.error) this.emit(error, this.error);
                        else if (!this.defining) {
                            if (this.defining = !0, 1this.depCount && !this.defined) {
                                if (l(f)) {
                                    if (this.events.error && this.map.isDefinet.onError !== et) try {
                                        n = s.execCb(u, f, r, n)
                                    } catch(e) {
                                        i = e
                                    } else n = s.execCb(u, f, r, n);
                                    if (this.map.isDefine && void 0 === n && ((r = this.module) n = r.exportsthis.usingExports && (n = this.exports)), i) return i.requireMap = this.map,
                                    i.requireModules = this.map.isDefine[this.map.id] null,
                                    i.requireType = this.map.isDefinedefinerequire,
                                    d(this.error = i)
                                } else n = f;
                                if (this.exports = n, this.map.isDefine && !this.ignore && (w[u] = n, t.onResourceLoad)) t.onResourceLoad(s, this.map, this.depMaps);
                                kt(u),
                                this.defined = !0
                            }
                            this.defining = !1,
                            this.defined && !this.defineEmitted && (this.defineEmitted = !0, this.emit(defined, this.exports), this.defineEmitComplete = !0)
                        }
                    } else this.fetch()
                },
                callPluginfunction() {
                    var n = this.map,
                    f = n.id,
                    e = k(n.prefix);
                    this.depMaps.push(e),
                    lt(e, defined, u(this,
                    function(e) {
                        var l, o;
                        o = i(fi, this.map.id);
                        var a = this.map.name,
                        w = this.map.parentMapthis.map.parentMap.namenull,
                        p = s.makeRequire(n.parentMap, {
                            enableBuildCallback ! 0
                        });
                        if (this.map.unnormalized) {
                            if (e.normalize && (a = e.normalize(a,
                            function(n) {
                                return ut(n, w, !0)
                            })), e = k(n.prefix + !+a, this.map.parentMap), lt(e, defined, u(this,
                            function(n) {
                                this.init([],
                                function() {
                                    return n
                                },
                                null, {
                                    enabled ! 0,
                                    ignore ! 0
                                })
                            })), o = i(y, e.id)) {
                                if (this.depMaps.push(e), this.events.error) o.on(error, u(this,
                                function(n) {
                                    this.emit(error, n)
                                }));
                                o.enable()
                            }
                        } else o(this.map.url = s.nameToUrl(o), this.load())(l = u(this,
                        function(n) {
                            this.init([],
                            function() {
                                return n
                            },
                            null, {
                                enabled ! 0
                            })
                        }), l.error = u(this,
                        function(n) {
                            this.inited = !0,
                            this.error = n,
                            n.requireModules = [f],
                            h(y,
                            function(n) {
                                0 === n.map.id.indexOf(f + _unnormalized) && kt(n.map.id)
                            }),
                            d(n)
                        }), l.fromText = u(this,
                        function(i, u) {
                            var e = n.name,
                            o = k(e),
                            h = b;
                            u && (i = u),
                            h && (b = !1),
                            st(o),
                            r(v.config, f) && (v.config[e] = v.config[f]);
                            try {
                                t.exec(i)
                            } catch(a) {
                                return d(c(fromtexteval, fromText eval
                                for + f + failed + a, a, [f]))
                            }
                            h && (b = !0),
                            this.depMaps.push(o),
                            s.completeLoad(e),
                            p([e], l)
                        }), e.load(n.name, p, l, v))
                    })),
                    s.enable(e, this),
                    this.pluginMaps[e.id] = e
                },
                enablefunction() {
                    ri[this.map.id] = this,
                    this.enabling = this.enabled = !0,
                    f(this.depMaps, u(this,
                    function(n, t) {
                        var f, e;
                        if (string == typeof n) {
                            if (n = k(n, this.map.isDefinethis.mapthis.map.parentMap, !1, !this.skipMap), this.depMaps[t] = n, f = i(ht, n.id)) {
                                this.depExports[t] = f(this);
                                return
                            }
                            this.depCount += 1,
                            lt(n, defined, u(this,
                            function(n) {
                                this.defineDep(t, n),
                                this.check()
                            })),
                            this.errback && lt(n, error, u(this, this.errback))
                        }
                        f = n.id,
                        e = y[f],
                        r(ht, f) ! ee.enableds.enable(n, this)
                    })),
                    h(this.pluginMaps, u(this,
                    function(n) {
                        var t = i(y, n.id);
                        t && !t.enabled && s.enable(n, this)
                    })),
                    this.enabling = !1,
                    this.check()
                },
                onfunction(n, t) {
                    var i = this.events[n];
                    i(i = this.events[n] = []),
                    i.push(t)
                },
                emitfunction(n, t) {
                    f(this.events[n],
                    function(n) {
                        n(t)
                    }),
                    error === n && delete this.events[n]
                }
            },
            s = {
                configv,
                contextNamee,
                registryy,
                definedw,
                urlFetchedat,
                defQueuert,
                Moduleti,
                makeModuleMapk,
                nextTickt.nextTick,
                onErrord,
                configurefunction(n) {
                    n.baseUrl && !==n.baseUrl.charAt(n.baseUrl.length - 1) && (n.baseUrl += );
                    var t = v.shim,
                    i = {
                        paths ! 0,
                        bundles ! 0,
                        config ! 0,
                        map ! 0
                    };
                    h(n,
                    function(n, t) {
                        i[t](v[t](v[t] = {}), it(v[t], n, !0, !0)) v[t] = n
                    }),
                    n.bundles && h(n.bundles,
                    function(n, t) {
                        f(n,
                        function(n) {
                            n !== t && (fi[n] = t)
                        })
                    }),
                    n.shim && (h(n.shim,
                    function(n, i) {
                        a(n) && (n = {
                            depsn
                        }),
                        (n.exportsn.init) && !n.exportsFn && (n.exportsFn = s.makeShimExports(n)),
                        t[i] = n
                    }), v.shim = t),
                    n.packages && f(n.packages,
                    function(n) {
                        var t, n = string == typeof n {
                            namen
                        }
                        n;
                        t = n.name,
                        n.location && (v.paths[t] = n.location),
                        v.pkgs[t] = n.name++(n.mainmain).replace(yt, ).replace(g, )
                    }),
                    h(y,
                    function(n, t) {
                        n.initedn.map.unnormalized(n.map = k(t))
                    }),
                    (n.depsn.callback) && s.require(n.deps[], n.callback)
                },
                makeShimExportsfunction(t) {
                    return function() {
                        var i;
                        return t.init && (i = t.init.apply(n, arguments)),
                        it.exports && ot(t.exports)
                    }
                },
                makeRequirefunction(n, u) {
                    function f(i, o, h) {
                        var a, v;
                        return (u.enableBuildCallback && o && l(o) && (o.__requireJsBuild = !0), string == typeof i) l(o) d(c(requireargs, Invalid require call), h) n && r(ht, i) ht[i](y[n.id]) t.gett.get(s, i, n, f)(a = k(i, n, !1, !0), a = a.id, r(w, a) w[a] d(c(notloaded, 'Module name ' + a + ' has not been loaded yet for context ' + e + (n.Use require([])))))(ci(), s.nextTick(function() {
                            ci(),
                            v = st(k(null, n)),
                            v.skipMap = u.skipMap,
                            v.init(i, o, h, {
                                enabled ! 0
                            }),
                            dt()
                        }), f)
                    }
                    return u = u {},
                    it(f, {
                        isBrowsero,
                        toUrlfunction(t) {
                            var r, i = t.lastIndexOf(.),
                            u = t.split()[0];
                            return - 1 !== i && (!(. === u.. === u) 1i) && (r = t.substring(i, t.length), t = t.substring(0, i)),
                            s.nameToUrl(ut(t, n && n.id, !0), r, !0)
                        },
                        definedfunction(t) {
                            return r(w, k(t, n, !1, !0).id)
                        },
                        specifiedfunction(t) {
                            return t = k(t, n, !1, !0).id,
                            r(w, t) r(y, t)
                        }
                    }),
                    n(f.undef = function(t) {
                        pt();
                        var u = k(t, n, !0),
                        r = i(y, t);
                        ei(t),
                        delete w[t],
                        delete at[u.url],
                        delete ui[t],
                        tt(rt,
                        function(n, i) {
                            n[0] === t && rt.splice(i, 1)
                        }),
                        r && (r.events.defined && (ui[t] = r.events), kt(t))
                    }),
                    f
                },
                enablefunction(n) {
                    i(y, n.id) && st(n).enable()
                },
                completeLoadfunction(n) {
                    var u, t, f = i(v.shim, n) {},
                    e = f.exports;
                    for (pt(); rt.length;) {
                        if (t = rt.shift(), null === t[0]) {
                            if (t[0] = n, u) break;
                            u = !0
                        } else t[0] === n && (u = !0);
                        gt(t)
                    }
                    if (t = i(y, n), !u && !r(w, n) && t && !t.inited) {
                        if (v.enforceDefine && (!e ! ot(e))) return vt(n) void 0d(c(nodefine, No define call
                        for + n, null, [n]));
                        gt([n, f.deps[], f.exportsFn])
                    }
                    dt()
                },
                nameToUrlfunction(n, r, u) {
                    var f, o, e;
                    if ((f = i(v.pkgs, n)) && (n = f), f = i(fi, n)) return s.nameToUrl(f, r, u);
                    if (t.jsExtRegExp.test(n)) f = n + (r);
                    else {
                        for (f = v.paths, n = n.split(), o = n.length; 0o; o -= 1) if (e = n.slice(0, o).join(), e = i(f, e)) {
                            a(e) && (e = e[0]),
                            n.splice(0, o, e);
                            break
                        }
                        f = n.join(),
                        f += r( ^ data.test(f) u.js),
                        f = ( === f.charAt(0) f.match( ^ [w + . - ] + ) v.baseUrl) + f
                    }
                    return v.urlArgsf + (( - 1 === f.indexOf() & ) + v.urlArgs) f
                },
                loadfunction(n, i) {
                    t.load(s, n, i)
                },
                execCbfunction(n, t, i, r) {
                    return t.apply(r, i)
                },
                onScriptLoadfunction(n) { (load === n.typebt.test((n.currentTargetn.srcElement).readyState)) && (p = null, n = hi(n), s.completeLoad(n.id))
                },
                onScriptErrorfunction(n) {
                    var t = hi(n);
                    if (!vt(t.id)) return d(c(scripterror, Script error
                    for + t.id, n, [t.id]))
                }
            },
            s.require = s.makeRequire(),
            s
        }
        var t, v, y, k, rt, d, p, ut, e, st, at = (([sS])([ ^ ] ^ )(.) $) mg,
        vt = [ ^ .] srequires(s[']([^'s] + )[']s)g,g=.js$,yt=^.;v=Object.prototype;var ht=v.toString,pt=v.hasOwnProperty,wt=Array.prototype.splice,o=!!(undefined!=typeof window&&undefined!=typeof navigator&&window.document),ct=!o&&undefined!=typeof importScripts,bt=o&&PLAYSTATION 3===navigator.platform^complete$^(completeloaded)$,ft=undefined!=typeof opera&&[object Opera]===opera.toString(),w={},s={},nt=[],b=!1;if(undefined==typeof define){if(undefined!=typeof requirejs){if(l(requirejs))return;s=requirejs,requirejs=void 0}undefined==typeof requirel(require)(s=require,require=void 0),t=requirejs=function(n,r,u,f){var e,o=_;return a(n)string==typeof n(e=n,a(r)(n=r,r=u,u=f)n=[]),e&&e.context&&(o=e.context),(f=i(w,o))(f=w[o]=t.s.newContext(o)),e&&f.configure(e),f.require(n,r,u)},t.config=function(n){return t(n)},t.nextTick=undefined!=typeof setTimeoutfunction(n){setTimeout(n,4)}function(n){n()},require(require=t),t.version=2.1.14,t.jsExtRegExp=^.js$,t.isBrowser=o,v=t.s={contextsw,newContextlt},t({}),f([toUrl,undef,defined,specified],function(n){t[n]=function(){var t=w._;return t.require[n].apply(t,arguments)}}),o&&(y=v.head=document.getElementsByTagName(head)[0],k=document.getElementsByTagName(base)[0])&&(y=v.head=k.parentNode),t.onError=et,t.createNode=function(n){var t=n.xhtmldocument.createElementNS(httpwww.w3.org1999xhtml,htmlscript)document.createElement(script);return t.type=n.scriptTypetextjavascript,t.charset=utf-8,t.async=!0,t},t.load=function(n,i,r){var u=n&&n.config{};if(o)return u=t.createNode(u,i,r),u.setAttribute(data-requirecontext,n.contextName),u.setAttribute(data-requiremodule,i),u.attachEvent&&!(u.attachEvent.toString&&0u.attachEvent.toString().indexOf([native code))&&!ft(b=!0,u.attachEvent(onreadystatechange,n.onScriptLoad))(u.addEventListener(load,n.onScriptLoad,!1),u.addEventListener(error,n.onScriptError,!1)),u.src=r,ut=u,ky.insertBefore(u,k)y.appendChild(u),ut=null,u;if(ct)try{importScripts(r),n.completeLoad(i)}catch(f){n.onError(c(importscripts,importScripts failed for +i+ at +r,f,[i]))}},o&&!s.skipDataMain&&tt(document.getElementsByTagName(script),function(n){return y(y=n.parentNode),(rt=n.getAttribute(data-main))(e=rt,s.baseUrl(d=e.split(),e=d.pop(),st=d.lengthd.join()+.,s.baseUrl=st),e=e.replace(g,),t.jsExtRegExp.test(e)&&(e=rt),s.deps=s.depss.deps.concat(e)[e],!0)void 0}),define=function(n,t,i){var r,u;string!=typeof n&&(i=t,t=n,n=null),a(t)(i=t,t=null),!t&&l(i)&&(t=[],i.length&&(i.toString().replace(at,).replace(vt,function(n,i){t.push(i)}),t=(1===i.length[require][require,exports,module]).concat(t))),b&&((r=ut)(p&&interactive===p.readyStatett(document.getElementsByTagName(script),function(n){if(interactive===n.readyState)return p=n}),r=p),r&&(n(n=r.getAttribute(data-requiremodule)),u=w[r.getAttribute(data-requirecontext)])),(uu.defQueuent).push([n,t,i])},define.amd={jQuery!0},t.exec=function(b){return eval(b)},t(s)}}(this),require.config({resource+baseUrlscripts,urlArgsr=+Math.random(),paths{artDialoglibartDialogjquery.artDialog,dialogdialog,ueditorLibueditorueditor.all,signalRLibsignalRjquery.signalR-2.0.0.min,json2LibsignalRjson2.min},shim{signalR{deps[json2],exportssignalR}}}),String.prototype.trim=function(){function eleContains(arg){var elestr=$(+.[^{,elearray,i;if(arg.length==1)elestr.indexOf(arg)-1arg=+argarg== &&(arg=s);else if(arg.length1)for(elearray=elestr.split(),i=0;ielearray.length;i++)arg.indexOf(elearray[i])-1arg=arg.replace(eval(+elearray[i]+g),+elearray[i])arg.indexOf( )-1&&(arg=arg.replace( ,s));return arg}var rstr,arg,i;if(arguments.length0){for(rstr=this,arg=,i=0;iarguments.length;i++)arg=arguments[i],arg=eleContains(arg),rstr=rstr.replace(eval((^+arg+)(+arg+$)g),);return rstr}return this.replace((^s)(s$)g,)},Date.prototype.format=function(n){var i={M+this.getMonth()+1,d+this.getDate(),H+this.getHours(),m+this.getMinutes(),s+this.getSeconds(),q+Math.floor((this.getMonth()+3)3),Sthis.getMilliseconds()},t;(y+).test(n)&&(n=n.replace(RegExp.$1,(this.getFullYear()+).substr(4-RegExp.$1.length)));for(t in i)new RegExp((+t+)).test(n)&&(n=n.replace(RegExp.$1,RegExp.$1.length==1i[t](00+i[t]).substr((+i[t]).length)));return n},Date.prototype.getTimeSpan=function(){var n=new Date-this;return n864e5n36e5arguments.length=1this.format(arguments[0])this.format(yyyy-MM-dd HHmm)n6e4parseInt(n6e4)+分钟前(parseInt(n1e3)2parseInt(n1e3)2)+秒前arguments.length=1this.format(arguments[0])this.format(yyyy-MM-dd HHmm)},CommonFn={formatCurrencyfunction(n){n=n.toString().replace($,g,),isNaN(n)&&(n=0),sign=n==(n=Math.abs(n)),n=Math.floor(n100+.50000000001),cents=n%100,n=Math.floor(n100).toString(),cents10&&(cents=0+cents);for(var t=0;tMath.floor((n.length-(1+t))3);t++)n=n.substring(0,n.length-(4t+3))+,+n.substring(n.length-(4t+3));return(sign-)+n+.+cents},addfavoritefunction(){try{document.allwindow.external.addFavorite(window.location.hostname,document.title)window.sidebar&&window.sidebar.addPanel(document.title,location.hostname,)}catch(n){alert(加入收藏失败，请使用Ctrl+D进行添加)}},getQueryStringfunction(n){var i=new RegExp((^&)+n+=([^&])(&$),i),t=window.location.search.substr(1).match(i);return t!=nullunescape(t[2])null},toFloatfunction(n,t){if(t=t2,n){var i=parseFloat(n);return i.toFixed(t)}},toDatefunction(n){return new Date(Date.parse(n.replace(-g,)))},toDateFromJsonfunction(obj){return obj=eval(new Date(+obj.replace([^d]g,)+))},clearHtmlfunction(n){var t=n,i=[^]+[^]+ig;return t=t.replace(i,)},cutStrfunction(n,t){var r,e,f,u,i;if(t==null)return;if(r=[u4E00-u9FA5uF900-uFA2D]ig,r.test(t)){if(e=t.replace(r,),e.lengthn)return t;for(f=,u=0,i=0;it.length;i++){if(u=n)break;f+=t.substr(i,1),u+=r.test(t.substr(i,1))21}return f.toString()+...}return t.lengthntt.substr(0,n)+...},clearImgTagfunction(n){return n.replace((imgs([^]{0,}))gi,)},getCookiefunction(n){var r=,t=;+document.cookie.replace(;s+g,;)+;,u=t.indexOf(;+n+=),i,f;return u-1&&(i=t.indexOf(=,u),f=t.indexOf(;,i),r=unescape(t.substring(i+1,f))),r}},$.ajaxSetup({cache!1})'