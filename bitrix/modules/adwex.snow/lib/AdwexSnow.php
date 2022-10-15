<?php
class AdwexSnow {
    public static function addSnow(&$content) {
        if (defined('SITE_ID') && \COption::GetOptionString(AdwexSnow\Tools::moduleID, 'SHOW_SNOW', '', SITE_ID) == 'Y') {
            $canShow = true;
            // Is JSON?
            if (is_object(json_decode($content))) {
                $canShow = false;
             // Is not Html
            } elseif (stripos($content, '<!DOCTYPE') === false ) {
                $canShow = false;
            } 
            $context = \Bitrix\Main\Application::getInstance()->getContext();
            $request = $context->getRequest();
            if ($request->isAjaxRequest()) {
                $canShow = false;
            }
            if ($canShow) {
                $script = '<script>var adwSnow={canvas:document.createElement("CANVAS"),canvasStyles:{pointerEvents:"none",position:"fixed",top:0,left:0,right:0,bottom:0,width:"100%",opacity:.8,zIndex:9999},ctx:null,snowColor:"rgb(255,255,255)",snowSize:1,width:window.innerWidth,height:window.innerHeight,delay:33,animationTimer:0,resizeTimeout:null,particles:[],snowCount:0,init:function(t){for(var i in"object"==typeof t&&"number"==typeof t.snowSize&&(this.snowSize=t.snowSize)&&"string"==typeof t.snowColor&&(this.snowColor=t.snowColor),this.canvasStyles)this.canvas.style[i]=this.canvasStyles[i];this.setCanvasSize(),document.body.appendChild(this.canvas),window.addEventListener("resize",function(){this.resizeTimeout||(this.resizeTimeout=setTimeout(function(){this.resizeTimeout=null,this.resizeHandler()}.bind(this),66))}.bind(this),!1),this.ctx=this.canvas.getContext("2d"),"object"==typeof this.ctx&&this.startPaint()},setCanvasSize:function(){return this.snowCount=.26*window.innerWidth,this.canvas.width=this.width=window.innerWidth,this.canvas.height=this.height=window.innerHeight,this},resizeHandler:function(){this.setCanvasSize()},startPaint:function(){for(var t=0;t<this.snowCount;t++)this.particles.push(new this.createParticles(t,Math.random()*this.width,Math.random()*this.height,this.snowSize));this.animationTimer=setInterval(this.newFrame.bind(this),this.delay)},createParticles:function(t,i,s,n){this.x=i,this.y=s,this.r=Math.random()+.25*n,this.xs=Math.random()*this.r*4-2,this.ys=this.r*Math.random()*2+1},newFrame:function(){this.ctx.globalCompositeOperation="source-over",this.ctx.clearRect(0,0,this.width,this.height);for(var t=0;t<this.particles.length;t++){var i=this.particles[t];this.ctx.beginPath(),this.ctx.fillStyle=this.snowColor,this.ctx.arc(i.x,i.y,i.r,2*Math.PI,!1),this.ctx.fill(),99<100*Math.random()&&(i.xs=Math.random()*i.r*4-2),i.y+=i.ys,i.x+=i.xs,(i.x>this.canvas.width||i.y>this.canvas.height)&&(i.x=Math.random()*this.canvas.width,i.y=-2)}}};adwSnow.init(#SETTINGS#);</script>';
                $replace = '{';
                $snowSize = \COption::GetOptionString(AdwexSnow\Tools::moduleID, 'SIZE_SNOW', '1', SITE_ID);
                $replace .= 'snowSize:'  . $snowSize . ',';
                $snowColor = \COption::GetOptionString(AdwexSnow\Tools::moduleID, 'COLOR_SNOW', '', SITE_ID);
                if (!empty($snowColor)) {
                    $replace .= 'snowColor:"'  . $snowColor . '",';
                }
                $replace .= '}';
                $script = str_replace('#SETTINGS#', $replace, $script);
                $content = str_replace('</body>', $script . '</body>', $content);
            }
        }
    }
}