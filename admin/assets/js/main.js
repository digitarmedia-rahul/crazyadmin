if ("undefined" == typeof jQuery) throw new Error("requires jQuery"); + function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var e = a(this),
                g = e.data(c);
            if (!g) {
                var h = a.extend({}, d, e.data(), "object" == typeof b && b);
                e.data(c, g = new f(e, h))
            }
            if ("string" == typeof g) {
                if (void 0 === g[b]) throw new Error("No method named " + b);
                g[b]()
            }
        })
    }
    var c = "lte.boxrefresh",
        d = {
            source: "",
            params: {},
            trigger: ".refresh-btn",
            content: ".box-body",
            loadInContent: !0,
            responseType: "",
            overlayTemplate: '<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>',
            onLoadStart: function() {},
            onLoadDone: function(a) {
                return a
            }
        },
        e = {
            data: '[data-widget="box-refresh"]'
        },
        f = function(b, c) {
            if (this.element = b, this.options = c, this.$overlay = a(c.overlayTemplate), "" === c.source) throw new Error("Source url was not defined. Please specify a url in your BoxRefresh source option.");
            this._setUpListeners(), this.load()
        };
    f.prototype.load = function() {
        this._addOverlay(), this.options.onLoadStart.call(a(this)), a.get(this.options.source, this.options.params, function(b) {
            this.options.loadInContent && a(this.element).find(this.options.content).html(b), this.options.onLoadDone.call(a(this), b), this._removeOverlay()
        }.bind(this), "" !== this.options.responseType && this.options.responseType)
    }, f.prototype._setUpListeners = function() {
        a(this.element).on("click", this.options.trigger, function(a) {
            a && a.preventDefault(), this.load()
        }.bind(this))
    }, f.prototype._addOverlay = function() {
        a(this.element).append(this.$overlay)
    }, f.prototype._removeOverlay = function() {
        a(this.$overlay).remove()
    };
    var g = a.fn.boxRefresh;
    a.fn.boxRefresh = b, a.fn.boxRefresh.Constructor = f, a.fn.boxRefresh.noConflict = function() {
        return a.fn.boxRefresh = g, this
    }, a(window).on("load", function() {
        a(e.data).each(function() {
            b.call(a(this))
        })
    })
}(jQuery),
function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var e = a(this),
                f = e.data(c);
            if (!f) {
                var g = a.extend({}, d, e.data(), "object" == typeof b && b);
                e.data(c, f = new h(e, g))
            }
            if ("string" == typeof b) {
                if (void 0 === f[b]) throw new Error("No method named " + b);
                f[b]()
            }
        })
    }
    var c = "lte.boxwidget",
        d = {
            animationSpeed: 500,
            collapseTrigger: '[data-widget="collapse"]',
            removeTrigger: '[data-widget="remove"]',
            collapseIcon: "fa-minus",
            expandIcon: "fa-plus",
            removeIcon: "fa-times"
        },
        e = {
            data: ".box",
            collapsed: ".collapsed-box",
            header: ".box-header",
            body: ".box-body",
            footer: ".box-footer",
            tools: ".box-tools"
        },
        f = {
            collapsed: "collapsed-box"
        },
        g = {
            collapsing: "collapsing.boxwidget",
            collapsed: "collapsed.boxwidget",
            expanding: "expanding.boxwidget",
            expanded: "expanded.boxwidget",
            removing: "removing.boxwidget",
            removed: "removed.boxwidget"
        },
        h = function(a, b) {
            this.element = a, this.options = b, this._setUpListeners()
        };
    h.prototype.toggle = function() {
        a(this.element).is(e.collapsed) ? this.expand() : this.collapse()
    }, h.prototype.expand = function() {
        var b = a.Event(g.expanded),
            c = a.Event(g.expanding),
            d = this.options.collapseIcon,
            h = this.options.expandIcon;
        a(this.element).removeClass(f.collapsed), a(this.element).children(e.header + ", " + e.body + ", " + e.footer).children(e.tools).find("." + h).removeClass(h).addClass(d), a(this.element).children(e.body + ", " + e.footer).slideDown(this.options.animationSpeed, function() {
            a(this.element).trigger(b)
        }.bind(this)).trigger(c)
    }, h.prototype.collapse = function() {
        var b = a.Event(g.collapsed),
            c = a.Event(g.collapsing),
            d = this.options.collapseIcon,
            h = this.options.expandIcon;
        a(this.element).children(e.header + ", " + e.body + ", " + e.footer).children(e.tools).find("." + d).removeClass(d).addClass(h), a(this.element).children(e.body + ", " + e.footer).slideUp(this.options.animationSpeed, function() {
            a(this.element).addClass(f.collapsed), a(this.element).trigger(b)
        }.bind(this)).trigger(c)
    }, h.prototype.remove = function() {
        var b = a.Event(g.removed),
            c = a.Event(g.removing);
        a(this.element).slideUp(this.options.animationSpeed, function() {
            a(this.element).trigger(b), a(this.element).remove()
        }.bind(this)).trigger(c)
    }, h.prototype._setUpListeners = function() {
        var b = this;
        a(this.element).on("click", this.options.collapseTrigger, function(c) {
            return c && c.preventDefault(), b.toggle(a(this)), !1
        }), a(this.element).on("click", this.options.removeTrigger, function(c) {
            return c && c.preventDefault(), b.remove(a(this)), !1
        })
    };
    var i = a.fn.boxWidget;
    a.fn.boxWidget = b, a.fn.boxWidget.Constructor = h, a.fn.boxWidget.noConflict = function() {
        return a.fn.boxWidget = i, this
    }, a(window).on("load", function() {
        a(e.data).each(function() {
            b.call(a(this))
        })
    })
}(jQuery),
function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var e = a(this),
                f = e.data(c);
            if (!f) {
                var g = a.extend({}, d, e.data(), "object" == typeof b && b);
                e.data(c, f = new h(e, g))
            }
            "string" == typeof b && f.toggle()
        })
    }
    var c = "lte.controlsidebar",
        d = {
            slide: !0
        },
        e = {
            sidebar: ".control-sidebar",
            data: '[data-toggle="control-sidebar"]',
            open: ".control-sidebar-open",
            bg: ".control-sidebar-bg",
            wrapper: ".wrapper",
            content: ".content-wrapper",
            boxed: ".layout-boxed"
        },
        f = {
            open: "control-sidebar-open",
            fixed: "fixed"
        },
        g = {
            collapsed: "collapsed.controlsidebar",
            expanded: "expanded.controlsidebar"
        },
        h = function(a, b) {
            this.element = a, this.options = b, this.hasBindedResize = !1, this.init()
        };
    h.prototype.init = function() {
        a(this.element).is(e.data) || a(this).on("click", this.toggle), this.fix(), a(window).resize(function() {
            this.fix()
        }.bind(this))
    }, h.prototype.toggle = function(b) {
        b && b.preventDefault(), this.fix(), a(e.sidebar).is(e.open) || a("body").is(e.open) ? this.collapse() : this.expand()
    }, h.prototype.expand = function() {
        a(e.sidebar).show(), this.options.slide ? a(e.sidebar).addClass(f.open) : a("body").addClass(f.open), a(this.element).trigger(a.Event(g.expanded))
    }, h.prototype.collapse = function() {
        a("body, " + e.sidebar).removeClass(f.open), a(e.sidebar).fadeOut(), a(this.element).trigger(a.Event(g.collapsed))
    }, h.prototype.fix = function() {
        a("body").is(e.boxed) && this._fixForBoxed(a(e.bg))
    }, h.prototype._fixForBoxed = function(b) {
        b.css({
            position: "absolute",
            height: a(e.wrapper).height()
        })
    };
    var i = a.fn.controlSidebar;
    a.fn.controlSidebar = b, a.fn.controlSidebar.Constructor = h, a.fn.controlSidebar.noConflict = function() {
        return a.fn.controlSidebar = i, this
    }, a(document).on("click", e.data, function(c) {
        c && c.preventDefault(), b.call(a(this), "toggle")
    })
}(jQuery),
function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var d = a(this),
                e = d.data(c);
            e || d.data(c, e = new f(d)), "string" == typeof b && e.toggle(d)
        })
    }
    var c = "lte.directchat",
        d = {
            data: '[data-widget="chat-pane-toggle"]',
            box: ".direct-chat"
        },
        e = {
            open: "direct-chat-contacts-open"
        },
        f = function(a) {
            this.element = a
        };
    f.prototype.toggle = function(a) {
        a.parents(d.box).first().toggleClass(e.open)
    };
    var g = a.fn.directChat;
    a.fn.directChat = b, a.fn.directChat.Constructor = f, a.fn.directChat.noConflict = function() {
        return a.fn.directChat = g, this
    }, a(document).on("click", d.data, function(c) {
        c && c.preventDefault(), b.call(a(this), "toggle")
    })
}(jQuery),
function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var e = a(this),
                f = e.data(c);
            if (!f) {
                var g = a.extend({}, d, e.data(), "object" == typeof b && b);
                e.data(c, f = new h(g))
            }
            "toggle" === b && f.toggle()
        })
    }
    var c = "lte.pushmenu",
        d = {
            collapseScreenSize: 767,
            expandOnHover: !1,
            expandTransitionDelay: 200
        },
        e = {
            collapsed: ".sidebar-collapse",
            open: ".sidebar-open",
            mainSidebar: ".main-sidebar",
            contentWrapper: ".content-wrapper",
            searchInput: ".sidebar-form .form-control",
            button: '[data-toggle="push-menu"]',
            mini: ".sidebar-mini",
            expanded: ".sidebar-expanded-on-hover",
            layoutFixed: ".fixed"
        },
        f = {
            collapsed: "sidebar-collapse",
            open: "sidebar-open",
            mini: "sidebar-mini",
            expanded: "sidebar-expanded-on-hover",
            expandFeature: "sidebar-mini-expand-feature",
            layoutFixed: "fixed"
        },
        g = {
            expanded: "expanded.pushMenu",
            collapsed: "collapsed.pushMenu"
        },
        h = function(a) {
            this.options = a, this.init()
        };
    h.prototype.init = function() {
        (this.options.expandOnHover || a("body").is(e.mini + e.layoutFixed)) && (this.expandOnHover(), a("body").addClass(f.expandFeature)), a(e.contentWrapper).click(function() {
            a(window).width() <= this.options.collapseScreenSize && a("body").hasClass(f.open) && this.close()
        }.bind(this)), a(e.searchInput).click(function(a) {
            a.stopPropagation()
        })
    }, h.prototype.toggle = function() {
        var b = a(window).width(),
            c = !a("body").hasClass(f.collapsed);
        b <= this.options.collapseScreenSize && (c = a("body").hasClass(f.open)), c ? this.close() : this.open()
    }, h.prototype.open = function() {
        a(window).width() > this.options.collapseScreenSize ? a("body").removeClass(f.collapsed).trigger(a.Event(g.expanded)) : a("body").addClass(f.open).trigger(a.Event(g.expanded))
    }, h.prototype.close = function() {
        a(window).width() > this.options.collapseScreenSize ? a("body").addClass(f.collapsed).trigger(a.Event(g.collapsed)) : a("body").removeClass(f.open + " " + f.collapsed).trigger(a.Event(g.collapsed))
    }, h.prototype.expandOnHover = function() {
        a(e.mainSidebar).hover(function() {
            a("body").is(e.mini + e.collapsed) && a(window).width() > this.options.collapseScreenSize && this.expand()
        }.bind(this), function() {
            a("body").is(e.expanded) && this.collapse()
        }.bind(this))
    }, h.prototype.expand = function() {
        setTimeout(function() {
            a("body").removeClass(f.collapsed).addClass(f.expanded)
        }, this.options.expandTransitionDelay)
    }, h.prototype.collapse = function() {
        setTimeout(function() {
            a("body").removeClass(f.expanded).addClass(f.collapsed)
        }, this.options.expandTransitionDelay)
    };
    var i = a.fn.pushMenu;
    a.fn.pushMenu = b, a.fn.pushMenu.Constructor = h, a.fn.pushMenu.noConflict = function() {
        return a.fn.pushMenu = i, this
    }, a(document).on("click", e.button, function(c) {
        c.preventDefault(), b.call(a(this), "toggle")
    }), a(window).on("load", function() {
        b.call(a(e.button))
    })
}(jQuery),
function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var e = a(this),
                f = e.data(c);
            if (!f) {
                var h = a.extend({}, d, e.data(), "object" == typeof b && b);
                e.data(c, f = new g(e, h))
            }
            if ("string" == typeof f) {
                if (void 0 === f[b]) throw new Error("No method named " + b);
                f[b]()
            }
        })
    }
    var c = "lte.todolist",
        d = {
            onCheck: function(a) {
                return a
            },
            onUnCheck: function(a) {
                return a
            }
        },
        e = {
            data: '[data-widget="todo-list"]'
        },
        f = {
            done: "done"
        },
        g = function(a, b) {
            this.element = a, this.options = b, this._setUpListeners()
        };
    g.prototype.toggle = function(a) {
        if (a.parents(e.li).first().toggleClass(f.done), !a.prop("checked")) return void this.unCheck(a);
        this.check(a)
    }, g.prototype.check = function(a) {
        this.options.onCheck.call(a)
    }, g.prototype.unCheck = function(a) {
        this.options.onUnCheck.call(a)
    }, g.prototype._setUpListeners = function() {
        var b = this;
        a(this.element).on("change ifChanged", "input:checkbox", function() {
            b.toggle(a(this))
        })
    };
    var h = a.fn.todoList;
    a.fn.todoList = b, a.fn.todoList.Constructor = g, a.fn.todoList.noConflict = function() {
        return a.fn.todoList = h, this
    }, a(window).on("load", function() {
        a(e.data).each(function() {
            b.call(a(this))
        })
    })
}(jQuery),
function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var e = a(this);
            if (!e.data(c)) {
                var f = a.extend({}, d, e.data(), "object" == typeof b && b);
                e.data(c, new h(e, f))
            }
        })
    }
    var c = "lte.tree",
        d = {
            animationSpeed: 500,
            accordion: !0,
            followLink: !1,
            trigger: ".treeview a"
        },
        e = {
            tree: ".tree",
            treeview: ".treeview",
            treeviewMenu: ".treeview-menu",
            open: ".menu-open, .active",
            li: "li",
            data: '[data-widget="tree"]',
            active: ".active"
        },
        f = {
            open: "menu-open",
            tree: "tree"
        },
        g = {
            collapsed: "collapsed.tree",
            expanded: "expanded.tree"
        },
        h = function(b, c) {
            this.element = b, this.options = c, a(this.element).addClass(f.tree), a(e.treeview + e.active, this.element).addClass(f.open), this._setUpListeners()
        };
    h.prototype.toggle = function(a, b) {
        var c = a.next(e.treeviewMenu),
            d = a.parent(),
            g = d.hasClass(f.open);
        d.is(e.treeview) && (this.options.followLink && "#" !== a.attr("href") || b.preventDefault(), g ? this.collapse(c, d) : this.expand(c, d))
    }, h.prototype.expand = function(b, c) {
        var d = a.Event(g.expanded);
        if (this.options.accordion) {
            var h = c.siblings(e.open),
                i = h.children(e.treeviewMenu);
            this.collapse(i, h)
        }
        c.addClass(f.open), b.slideDown(this.options.animationSpeed, function() {
            a(this.element).trigger(d)
        }.bind(this))
    }, h.prototype.collapse = function(b, c) {
        var d = a.Event(g.collapsed);
        c.removeClass(f.open), b.slideUp(this.options.animationSpeed, function() {
            a(this.element).trigger(d)
        }.bind(this))
    }, h.prototype._setUpListeners = function() {
        var b = this;
        a(this.element).on("click", this.options.trigger, function(c) {
            b.toggle(a(this), c)
        })
    };
    var i = a.fn.tree;
    a.fn.tree = b, a.fn.tree.Constructor = h, a.fn.tree.noConflict = function() {
        return a.fn.tree = i, this
    }, a(window).on("load", function() {
        a(e.data).each(function() {
            b.call(a(this))
        })
    })
}(jQuery),
function(a) {
    "use strict";

    function b(b) {
        return this.each(function() {
            var e = a(this),
                f = e.data(c);
            if (!f) {
                var h = a.extend({}, d, e.data(), "object" == typeof b && b);
                e.data(c, f = new g(h))
            }
            if ("string" == typeof b) {
                if (void 0 === f[b]) throw new Error("No method named " + b);
                f[b]()
            }
        })
    }
    var c = "lte.layout",
        d = {
            slimscroll: !0,
            resetHeight: !0
        },
        e = {
            wrapper: ".wrapper",
            contentWrapper: ".content-wrapper",
            layoutBoxed: ".layout-boxed",
            mainFooter: ".main-footer",
            mainHeader: ".main-header",
            sidebar: ".sidebar",
            controlSidebar: ".control-sidebar",
            fixed: ".fixed",
            sidebarMenu: ".sidebar-menu",
            logo: ".main-header .logo"
        },
        f = {
            fixed: "fixed",
            holdTransition: "hold-transition"
        },
        g = function(a) {
            this.options = a, this.bindedResize = !1, this.activate()
        };
    g.prototype.activate = function() {
        this.fix(), this.fixSidebar(), a("body").removeClass(f.holdTransition), this.options.resetHeight && a("body, html, " + e.wrapper).css({
            height: "auto",
            "min-height": "100%"
        }), this.bindedResize || (a(window).resize(function() {
            this.fix(), this.fixSidebar(), a(e.logo + ", " + e.sidebar).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function() {
                this.fix(), this.fixSidebar()
            }.bind(this))
        }.bind(this)), this.bindedResize = !0), a(e.sidebarMenu).on("expanded.tree", function() {
            this.fix(), this.fixSidebar()
        }.bind(this)), a(e.sidebarMenu).on("collapsed.tree", function() {
            this.fix(), this.fixSidebar()
        }.bind(this))
    }, g.prototype.fix = function() {
        a(e.layoutBoxed + " > " + e.wrapper).css("overflow", "hidden");
        var b = a(e.mainFooter).outerHeight() || 0,
            c = a(e.mainHeader).outerHeight() || 0,
            d = c + b,
            g = a(window).height(),
            h = a(e.sidebar).height() || 0;
        if (a("body").hasClass(f.fixed)) a(e.contentWrapper).css("min-height", g - b);
        else {
            var i;
            g >= h + c ? (a(e.contentWrapper).css("min-height", g - d), i = g - d) : (a(e.contentWrapper).css("min-height", h), i = h);
            var j = a(e.controlSidebar);
            void 0 !== j && j.height() > i && a(e.contentWrapper).css("min-height", j.height())
        }
    }, g.prototype.fixSidebar = function() {
        if (!a("body").hasClass(f.fixed)) return void(void 0 !== a.fn.slimScroll && a(e.sidebar).slimScroll({
            destroy: !0
        }).height("auto"));
        this.options.slimscroll && void 0 !== a.fn.slimScroll && a(e.sidebar).slimScroll({
            height: a(window).height() - a(e.mainHeader).height() + "px"
        })
    };
    var h = a.fn.layout;
    a.fn.layout = b, a.fn.layout.Constuctor = g, a.fn.layout.noConflict = function() {
        return a.fn.layout = h, this
    }, a(window).on("load", function() {
        b.call(a("body"))
    })
}(jQuery);