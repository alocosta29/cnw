// estilo em menu.css

(function() 
{
	var menu,userAgent=navigator.userAgent.toLowerCase(),opera=/opera/.test(userAgent),
	
		onLoad=function()
		{
			var name="mhjscss";
			var divs=document.getElementsByTagName("div");
			
			for(var i=0;i<divs.length;i++)
			{
				if(divs[i].className==name)
				{
					menu=divs[i];
					var lis=menu.getElementsByTagName("li");
				
					for(var n=lis[0];n;n=n.nextSibling)
					
					if(n.tagName=="LI")
					{
						n.ajxtop=true;
						
						if(opera)n.style.width=n.offsetWidth-(n.className.indexOf("tlast")==-1? 0:0);
					}
					
					for(var j=0;j<lis.length;j++)
					{
						lis[j].className=lis[j].className;lis[j].style.position="static";
						var uls=lis[j].getElementsByTagName("ul");
						
						if(uls.length>0)uls[0].style.display="none";lis[j].shown=lis[j].show=false;lis[j].onmouseover=function()
						{
							clearTimeout(menu.timer);
							
							if(this.className.indexOf("ajxover")==-1)this.className+=" ajxover";
							this.show=true;
							menu.timer=setTimeout(update,160);
						};
							
							lis[j].onmouseout=function()
							{
								clearTimeout(menu.timer);
								
								if(!this.shown)this.className=this.className.replace(new RegExp(" ?ajxover\\b"), "");
								this.show=false;
								menu.timer=setTimeout(update,600);
							};
					}
				}
			}
		},
		
		update=function()
		{
			var lis=menu.getElementsByTagName("li");
			
			for(var i=lis.length-1;i>=0;i--)
			{
				if(lis[i].show)
				{
					if(!lis[i].shown)
					{
						if(!lis[i].parentNode.style.filter)
						{
							var uls=lis[i].getElementsByTagName("ul");
							if(uls.length>0)
							{
								lis[i].style.position="relative";
								uls[0].style.filter="alpha(opacity=0)";
								uls[0].style.opacity=0;uls[0].style.display="block";
								fadeIn(uls[0]);lis[i].shown=true;
							}
						}
						else 
						setTimeout(update,13);
					}
				}
				else
				{
					var uls=lis[i].getElementsByTagName("ul");
					
					if(uls.length>0)
					{
						uls[0].style.display="none";
						lis[i].style.position="static";
						lis[i].shown=false;if(lis[i].className.indexOf("ajxover")!=-1)lis[i].className=lis[i].className.replace(new RegExp(" ?ajxover\\b"), "");
					}
				}
			}
		},
		
		fadeIn=function(o)
		{
			o.tstart=new Date;
			if(!o.timer)o.timer=setInterval(
			function()
			{
				var s=(new Date-o.tstart)/400;if(s<1)
				{
					var v=s;o.style.filter="alpha(opacity="+v*100+")";o.style.opacity=v;
				}
				else
				{
					clearInterval(o.timer);
					o.timer=undefined;
					o.style.filter="";o.style.opacity=1;
				}
			}, 
			13);
		},
		
		addOnReady=function(f,fu)
		{
			var isReady=false,ready=function()
			{
				if(!isReady)
				{
					isReady=true;
					f();
				};
			};
			
			if(document.addEventListener)
			{
				document.addEventListener('DOMContentLoaded',ready,false);
				window.addEventListener("load",ready,false);
				window.addEventListener("unload",fu,false);
			}
			
			if(window.attachEvent)window.attachEvent("onload",ready);
			if(document.documentElement.doScroll&&window==top)
			{
				(function()
				{
					if(!isReady)
					{
						try
						{document.documentElement.doScroll("left");}
						catch(E)
						{
							setTimeout(arguments.callee,0);
							return;
						}
						
						ready();
					}
					
				}
				)
				()
			}
		};
		
		addOnReady(onLoad, onLoad);
}	
)();


/**
 *
 * Layout
 *
 * Juiz de Fora, janeiro de 2012, Minas Gerais.
 *
 * Virtual Telecom
 * Engenharia de rede 
 * Departamento de Desenvolvimento Interno
 *
 * Diretor: Armando da S. Barbosa (armando@inforwave.com.br)
 * Gerência: Vinicius P. Barbosa (vbarbosa@inforwave.com.br)
 * Desenvolvedor: Christiano G. de Araújo (desenvolvimento@virtualtelecom.com.br)
 * Time de Programação: Christiano G. de Araújo, Henrique R. Melo (henriquemelo@virtualtelecom.com.br) e Rafael Amaral (amaral@inforwave.com.br).
 * 
 */