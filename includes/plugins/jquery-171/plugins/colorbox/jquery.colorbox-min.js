(function(H,k,U){var I={transition:"elastic",speed:300,width:false,initialWidth:"600",innerWidth:false,maxWidth:false,height:false,initialHeight:"450",innerHeight:false,maxHeight:false,minWidth:false,minHeight:false,scalePhotos:true,scrolling:true,inline:false,html:false,iframe:false,fastIframe:true,photo:false,href:false,title:false,rel:false,opacity:0.9,preloading:true,current:"{current} / {total}",previous:"previous",next:"next",close:"close",open:false,returnFocus:true,loop:true,slideshow:false,slideshowAuto:true,slideshowSpeed:2500,slideshowStart:"start slideshow",slideshowStop:"stop slideshow",onOpen:false,onLoad:false,onComplete:false,onCleanup:false,onClosed:false,overlayClose:true,escKey:true,arrowKey:true,top:false,bottom:false,left:false,right:false,fixed:false,data:undefined},v="colorbox",Q="cbox",p=Q+"Element",T=Q+"_open",e=Q+"_load",S=Q+"_complete",s=Q+"_cleanup",Z=Q+"_closed",i=Q+"_purge",t=H.browser.msie&&!H.support.opacity,ac=t&&H.browser.version<7,Y=Q+"_IE6",O,ad,ae,d,F,o,b,N,c,X,L,j,h,n,r,V,q,P,x,z,ab,af,l,g,a,u,G,m,B,W,K,y,J,aa="div";function E(ag,aj,ai){var ah=k.createElement(ag);if(aj){ah.id=Q+aj}if(ai){ah.style.cssText=ai}return H(ah)}function C(ah){var ag=c.length,ai=(G+ah)%ag;return(ai<0)?ag+ai:ai}function M(ag,ah){return Math.round((/%/.test(ag)?((ah==="x"?X.width():X.height())/100):1)*parseInt(ag,10))}function A(ag){return ab.photo||/\.(gif|png|jpe?g|bmp|ico)((#|\?).*)?$/i.test(ag)}function R(){var ag;ab=H.extend({},H.data(u,v));for(ag in ab){if(H.isFunction(ab[ag])&&ag.slice(0,2)!=="on"){ab[ag]=ab[ag].call(u)}}ab.rel=ab.rel||u.rel||"nofollow";ab.href=ab.href||H(u).attr("href");ab.title=ab.title||u.title;if(typeof ab.href==="string"){ab.href=H.trim(ab.href)}}function D(ag,ah){H.event.trigger(ag);if(ah){ah.call(u)}}function w(){var ah,aj=Q+"Slideshow_",ak="click."+Q,al,ai,ag;if(ab.slideshow&&c[1]){al=function(){V.text(ab.slideshowStop).unbind(ak).bind(S,function(){if(G<c.length-1||ab.loop){ah=setTimeout(J.next,ab.slideshowSpeed)}}).bind(e,function(){clearTimeout(ah)}).one(ak+" "+s,ai);ad.removeClass(aj+"off").addClass(aj+"on");ah=setTimeout(J.next,ab.slideshowSpeed)};ai=function(){clearTimeout(ah);V.text(ab.slideshowStart).unbind([S,e,s,ak].join(" ")).one(ak,function(){J.next();al()});ad.removeClass(aj+"on").addClass(aj+"off")};if(ab.slideshowAuto){al()}else{ai()}}else{ad.removeClass(aj+"off "+aj+"on")}}function f(ah){if(!K){u=ah;R();c=H(u);G=0;if(ab.rel!=="nofollow"){c=H("."+p).filter(function(){var ai=H.data(this,v).rel||this.rel;return(ai===ab.rel)});G=c.index(u);if(G===-1){c=c.add(u);G=c.length-1}}if(!B){B=W=true;ad.show();if(ab.returnFocus){try{u.blur();H(u).one(Z,function(){try{this.focus()}catch(ai){}})}catch(ag){}}O.css({opacity:+ab.opacity,cursor:ab.overlayClose?"pointer":"auto"}).show();ab.w=M(ab.initialWidth,"x");ab.h=M(ab.initialHeight,"y");J.position();if(ac){X.bind("resize."+Y+" scroll."+Y,function(){O.css({width:X.width(),height:X.height(),top:X.scrollTop(),left:X.scrollLeft()})}).trigger("resize."+Y)}D(T,ab.onOpen);z.add(n).hide();x.html(ab.close).show()}J.load(true)}}J=H.fn[v]=H[v]=function(ag,ai){var ah=this;ag=ag||{};J.init();if(!ah[0]){if(ah.selector){return ah}ah=H("<a/>");ag.open=true}if(ai){ag.onComplete=ai}ah.each(function(){H.data(this,v,H.extend({},H.data(this,v)||I,ag));H(this).addClass(p)});if((H.isFunction(ag.open)&&ag.open.call(ah))||ag.open){f(ah[0])}return ah};J.init=function(){if(!ad){if(!H("body")[0]){H(J.init);return}X=H(U);ad=E(aa).attr({id:v,"class":t?Q+(ac?"IE6":"IE"):""});O=E(aa,"Overlay",ac?"position:absolute":"").hide();ae=E(aa,"Wrapper");d=E(aa,"Content").append(L=E(aa,"LoadedContent","width:0; height:0; overflow:hidden"),h=E(aa,"LoadingOverlay").add(E(aa,"LoadingGraphic")),n=E(aa,"Title"),r=E(aa,"Current"),q=E(aa,"Next"),P=E(aa,"Previous"),V=E(aa,"Slideshow").bind(T,w),x=E(aa,"Close"));ae.append(E(aa).append(E(aa,"TopLeft"),F=E(aa,"TopCenter"),E(aa,"TopRight")),E(aa,false,"clear:left").append(o=E(aa,"MiddleLeft"),d,b=E(aa,"MiddleRight")),E(aa,false,"clear:left").append(E(aa,"BottomLeft"),N=E(aa,"BottomCenter"),E(aa,"BottomRight"))).find("div div").css({"float":"left"});j=E(aa,false,"position:absolute; width:9999px; visibility:hidden; display:none");H("body").prepend(O,ad.append(ae,j));af=F.height()+N.height()+d.outerHeight(true)-d.height();l=o.width()+b.width()+d.outerWidth(true)-d.width();g=L.outerHeight(true);a=L.outerWidth(true);ad.css({"padding-bottom":af,"padding-right":l}).hide();q.click(function(){J.next()});P.click(function(){J.prev()});x.click(function(){J.close()});z=q.add(P).add(r).add(V);O.click(function(){if(ab.overlayClose){J.close()}});H(k).bind("keydown."+Q,function(ah){var ag=ah.keyCode;if(B&&ab.escKey&&ag===27){ah.preventDefault();J.close()}if(B&&ab.arrowKey&&c[1]){if(ag===37){ah.preventDefault();P.click()}else{if(ag===39){ah.preventDefault();q.click()}}}})}};J.remove=function(){ad.add(O).remove();ad=null;H("."+p).removeData(v).removeClass(p)};J.position=function(ah,ag){var aj=0,ai=0,ak=ad.offset();X.unbind("resize."+Q);ad.css({top:-99999,left:-99999});if(ab.fixed&&!ac){ad.css({position:"fixed"})}else{aj=X.scrollTop();ai=X.scrollLeft();ad.css({position:"absolute"})}if(ab.right!==false){ai+=Math.max(X.width()-ab.w-a-l-M(ab.right,"x"),0)}else{if(ab.left!==false){ai+=M(ab.left,"x")}else{ai+=Math.round(Math.max(X.width()-ab.w-a-l,0)/2)}}if(ab.bottom!==false){aj+=Math.max(X.height()-ab.h-g-af-M(ab.bottom,"y"),0)}else{if(ab.top!==false){aj+=M(ab.top,"y")}else{aj+=Math.round(Math.max(X.height()-ab.h-g-af,0)/2)}}ad.css({top:ak.top,left:ak.left});ah=(ad.width()===ab.w+a&&ad.height()===ab.h+g)?0:ah||0;ae[0].style.width=ae[0].style.height="9999px";function al(am){F[0].style.width=N[0].style.width=d[0].style.width=am.style.width;h[0].style.height=h[1].style.height=d[0].style.height=o[0].style.height=b[0].style.height=am.style.height}ad.dequeue().animate({width:ab.w+a,height:ab.h+g,top:aj,left:ai},{duration:ah,complete:function(){al(this);W=false;ae[0].style.width=(ab.w+a+l)+"px";ae[0].style.height=(ab.h+g+af)+"px";if(ag){ag()}setTimeout(function(){X.bind("resize."+Q,J.position)},1)},step:function(){al(this)}})};J.resize=function(ag){if(B){ag=ag||{};if(ag.width){ab.w=M(ag.width,"x")-a-l}if(ag.innerWidth){ab.w=M(ag.innerWidth,"x")}L.css({width:ab.w});if(ag.height){ab.h=M(ag.height,"y")-g-af}if(ag.innerHeight){ab.h=M(ag.innerHeight,"y")}if(!ag.innerHeight&&!ag.height){L.css({height:"auto"});ab.h=L.height()}L.css({height:ab.h});J.position(ab.transition==="none"?0:ab.speed)}};J.prep=function(ah){if(!B){return}var ak,ai=ab.transition==="none"?0:ab.speed;L.remove();L=E(aa,"LoadedContent").append(ah);function ag(){ab.w=ab.w||L.width();if(ab.minWidth&&ab.w<ab.minWidth){ab.w=M(ab.minWidth,"x")}ab.w=ab.mw&&ab.mw<ab.w?ab.mw:ab.w;return ab.w}function aj(){ab.h=ab.h||L.height();if(ab.minHeight&&ab.h<ab.minHeight){ab.h=M(ab.minHeight,"y")}ab.h=ab.mh&&ab.mh<ab.h?ab.mh:ab.h;return ab.h}L.hide().appendTo(j.show()).css({width:ag(),overflow:ab.scrolling?"auto":"hidden"}).css({height:aj()}).prependTo(d);j.hide();H(m).css({"float":"none"});if(ac){H("select").not(ad.find("select")).filter(function(){return this.style.visibility!=="hidden"}).css({visibility:"hidden"}).one(s,function(){this.style.visibility="inherit"})}ak=function(){var av,ar,at=c.length,ap,au="frameBorder",ao="allowTransparency",am,al,aq;if(!B){return}function an(){if(t){ad[0].style.removeAttribute("filter")}}am=function(){clearTimeout(y);h.hide();D(S,ab.onComplete)};if(t){if(m){L.fadeIn(100)}}n.html(ab.title).add(L).show();if(at>1){if(typeof ab.current==="string"){r.html(ab.current.replace("{current}",G+1).replace("{total}",at)).show()}if(typeof ab.current==="string"){var aw="";for(ar=1;ar<=at;ar++){if(G+1==ar){aw+='<div class="link-actif">'+ar+"</div>"}else{aw+='<div class="link">'+ar+"</div>"}}r.html(aw).show();H("#cboxCurrent").children().click(function(){var ax=H("#cboxCurrent").children().index(this);J.allerImage(ax);this.className="link-actif"})}q[(ab.loop||G<at-1)?"show":"hide"]().html(ab.next);P[(ab.loop||G)?"show":"hide"]().html(ab.previous);if(ab.slideshow){V.show()}if(ab.preloading){av=[C(-1),C(1)];while((ar=c[av.pop()])){al=H.data(ar,v).href||ar.href;if(H.isFunction(al)){al=al.call(ar)}if(A(al)){aq=new Image();aq.src=al}}}}else{z.hide()}if(ab.iframe){ap=E("iframe")[0];if(au in ap){ap[au]=0}if(ao in ap){ap[ao]="true"}ap.name=Q+(+new Date());if(ab.fastIframe){am()}else{H(ap).one("load",am)}ap.src=ab.href;if(!ab.scrolling){ap.scrolling="no"}H(ap).addClass(Q+"Iframe").appendTo(L).one(i,function(){ap.src="//about:blank"})}else{am()}if(ab.transition==="fade"){ad.fadeTo(ai,1,an)}else{an()}};if(ab.transition==="fade"){ad.fadeTo(ai,0,function(){J.position(0,ak)})}else{J.position(ai,ak)}};J.load=function(ai){var ah,aj,ag=J.prep;W=true;m=false;u=c[G];if(!ai){R()}D(i);D(e,ab.onLoad);ab.h=ab.height?M(ab.height,"y")-g-af:ab.innerHeight&&M(ab.innerHeight,"y");ab.w=ab.width?M(ab.width,"x")-a-l:ab.innerWidth&&M(ab.innerWidth,"x");ab.mw=ab.w;ab.mh=ab.h;if(ab.maxWidth){ab.mw=M(ab.maxWidth,"x")-a-l;ab.mw=ab.w&&ab.w<ab.mw?ab.w:ab.mw}if(ab.maxHeight){ab.mh=M(ab.maxHeight,"y")-g-af;ab.mh=ab.h&&ab.h<ab.mh?ab.h:ab.mh}ah=ab.href;y=setTimeout(function(){h.show()},100);if(ab.inline){E(aa).hide().insertBefore(H(ah)[0]).one(i,function(){H(this).replaceWith(L.children())});ag(H(ah))}else{if(ab.iframe){ag(" ")}else{if(ab.html){ag(ab.html)}else{if(A(ah)){H(m=new Image()).addClass(Q+"Photo").error(function(){ab.title=false;ag(E(aa,"Error").text("This image could not be loaded"))}).load(function(){var ak;m.onload=null;if(ab.scalePhotos){aj=function(){m.height-=m.height*ak;m.width-=m.width*ak};if(ab.mw&&m.width>ab.mw){ak=(m.width-ab.mw)/m.width;aj()}if(ab.mh&&m.height>ab.mh){ak=(m.height-ab.mh)/m.height;aj()}}if(ab.h){m.style.marginTop=Math.max(ab.h-m.height,0)/2+"px"}if(c[1]&&(G<c.length-1||ab.loop)){m.style.cursor="pointer";m.onclick=function(){J.next()}}if(t){m.style.msInterpolationMode="bicubic"}setTimeout(function(){ag(m)},1)});setTimeout(function(){m.src=ah},1)}else{if(ah){j.load(ah,ab.data,function(al,ak,am){ag(ak==="error"?E(aa,"Error").text("Request unsuccessful: "+am.statusText):H(this).contents())})}}}}}};J.next=function(){if(!W&&c[1]&&(G<c.length-1||ab.loop)){G=C(1);J.load()}};J.allerImage=function(ag){G=ag;J.load()};J.prev=function(){if(!W&&c[1]&&(G||ab.loop)){G=C(-1);J.load()}};J.close=function(){if(B&&!K){K=true;B=false;D(s,ab.onCleanup);X.unbind("."+Q+" ."+Y);O.fadeTo(200,0);ad.stop().fadeTo(300,0,function(){ad.add(O).css({opacity:1,cursor:"auto"}).hide();D(i);L.remove();setTimeout(function(){K=false;D(Z,ab.onClosed)},1)})}};J.element=function(){return H(u)};J.settings=I;H("."+p,k).live("click",function(ag){if(!(ag.which>1||ag.shiftKey||ag.altKey||ag.metaKey)){ag.preventDefault();f(this)}});J.init()}(jQuery,document,this));