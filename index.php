<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		
		<meta http-equiv="X-UA-Compatible" content="IE=11">
		<title>Lazy's Live</title>
		<link rel="icon" href="https://i.zerodream.net/86b5133c13a7e7109b89f8d24fc0b746.jpg">
		<link rel="stylesheet" href="./resources/shit.css?version=202109211212">
		<link href="https://cdn.bootcdn.net/ajax/libs/mdui/1.0.2/css/mdui.min.css" rel="stylesheet">
		<link href="https://cdn.bootcdn.net/ajax/libs/dplayer/1.9.1/DPlayer.min.css" rel="stylesheet">
		<link href="https://s1.imlazy.ink:233/node_modules/@sweetalert2/theme-material-ui/material-ui.css" rel="stylesheet">
	</head>
	<body class="mdui-theme-layout-auto">
		<div id="bg"></div>
		<img class="NekohaShizuku" src="https://imgs.lovpass.cn/img/2021/06/30/99535bc41007020210630.png">
		<div class="mdui-container">
			<div class="mdui-row">
				<div class="mdui-col-sm-12">
					<div class="mdui-appbar logo">
  						<div class="mdui-toolbar mdui-color-light-blue-a700">
    						<a href="javascript:;" class="mdui-typo-headline">Lazy's Live</a>
    						<a href="javascript:;" class="mdui-typo-title phone-visit">个人直播，测试用。欢迎收看~</a>
    						<div class="mdui-toolbar-spacer"></div>
    						<a href="https://www.lazy.ink" class="mdui-shadow-3 mdui-btn mdui-btn-ripple mdui-color-pink-400 pc-visit phone-visit">
    			    			<i class="mdui-icon material-icons">&#xe88a;</i> 主页
							</a>
							<a href="https://blog.imlazy.ink:233" class="mdui-shadow-3 mdui-btn mdui-btn-ripple mdui-color-deep-purple-500 phone-visit">
								<i class="mdui-icon material-icons">&#xe3e3;</i> 博客
							</a>
							<a href="https://api.imlazy.ink" class="mdui-shadow-3 mdui-btn mdui-btn-ripple mdui-color-teal-500 phone-visit">
								<i class="mdui-icon material-icons">&#xe53b;</i> API
							</a>
							<a href="javascript:void(0);" class="mdui-shadow-3 mdui-btn mdui-btn-ripple">
								<i class="mdui-icon material-icons">&#xe853;</i> <span class="login-top" onclick="login()">未登录</span>
							</a>
  						</div>
					</div>
				</div>
			</div>

			<div class="mdui-row mb10">
				<div class="mdui-col-sm-9 mb10">
					<div class="mdui-card mdui-color-black">
						<div class="" style="padding: 6px 14px;">
							<span class="livEstatus"></span><span id="status">Loading...</span>：<span id="description"></span>
						</div>
						<div id="dplayer" style="display:block"></div>
					</div>
				</div>

				<div class="mdui-col-sm-3 commentlab">
					<div class="comments mdui-card ">
						<div class="CardTitle">
							实时聊天<span style="float:right;font-size: 14px;"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;当前在线：<span id="online">-</span>人</span>
						</div>
						<div class="CardBody commentdata">
							<div class="msgcontent" id="content">
								
							</div>
						</div>
						<button class="mdui-btn mdui-btn-block loginned mdui-color-pink-400 mdui-ripple" onclick="login()">登陆即可发送弹幕</button>
					</div>
				</div>
			</div>

			<div class="mdui-row">
				<div class="mdui-col-sm-12">
					<div class="mdui-card">
						<div class="mdui-card-content mdui-text-center mdui-typo">
                			<strong>
                  				Copyright © 2021 <a href="https://www.lazy.ink/" target="_blank">Lazy</a> Rights Reserved.
               				 </strong>
              			</div>
					</div>
				</div>
			</div>
		</div>
		

		<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
		<script src="https://cdn.bootcdn.net/ajax/libs/dplayer/1.26.0/DPlayer.min.js"></script>
		<script type="text/javascript" src="./resources/jquery.min.js"></script>
		<script src="https://cdn.bootcdn.net/ajax/libs/mdui/1.0.2/js/mdui.min.js"></script>
		<script src="https://s1.imlazy.ink:233/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
		<script type="text/javascript">
			//初始化播放器
			const dp = new DPlayer({
				container: document.getElementById('dplayer'),
				live:true,
				autoplay:true,
				video: {
					url: 'https://s1.imlazy.ink:233/hls/test/index.m3u8',	//直播源
					type: 'auto',
				},
				danmaku: true,
			});

			//获取直播间状态
			$(document).ready(function(){
				$.getJSON("https://s1.imlazy.ink:233/info.json?" + Date(),function(response){
					$("#livEstatus").css("background",response.status_color);
					$('#status').replaceWith(response.status);
					$('#description').replaceWith(response.description);
					if (response.status != "离线") {
						document.title = "正在直播："+response.description+" - Lazy's Live"
					}
				});
			});

			//初始化弹窗
			const Toast = Swal.mixin({
  				toast: true,
  				position: 'top-end',
  				showConfirmButton: false,
  				timer: 3000,
  				timerProgressBar: true,
  				didOpen: (toast) => {
    				toast.addEventListener('mouseenter', Swal.stopTimer)
    				toast.addEventListener('mouseleave', Swal.resumeTimer)
  				}
			})
			
			//登录
			function login(){
				(async () => {
					const { value: formValues } = await Swal.fire({
  						title: '登 录',
  						html:
							'使用你的 FxCraft 账号'+
    						'<input id="username" type="text" class="swal2-input" placeholder="玩家名或邮箱">' +
    						'<input id="password" type="password" class="swal2-input" placeholder="密码">'+
							'<br><a href="https://www.fxcraft.cn/auth/register">我没账号</a> | <a href="https://www.fxcraft.cn/auth/forgot">忘记密码</a>',
  						focusConfirm: false,
						showCancelButton: true,
						cancelButtonText: '取消',
						confirmButtonText: '登录',
						reverseButtons: true,
						allowEnterKey: true,
  						preConfirm: () => {
							// 这里用的是Blessing Skin的yggdrasil登录
							// 技术菜，没办法
							$.ajax({
      							type: "POST",
      							url: "https://www.fxcraft.cn/api/yggdrasil/authserver/authenticate/",
								contentType: "application/json",
								dataType : "json",
      							data: JSON.stringify({"username": $("#username").val(),"password": $("#password").val()}),
      							success: function(sucMsg){
									console.log(sucMsg);
									Toast.fire({
  										icon: 'success',
  										title: '登录成功'
									});
									$('.login-top').replaceWith('<span id=loginnedname>'+sucMsg.selectedProfile.name+'</span>');
									$('.loginned').replaceWith('<input type="text" id="comment" class="inputcontent" max="128" placeholder="输入后回车发送" onkeydown="keyup_submit(event);">');
									//建立连接,并发送连接进入房间(并且连接会一直保存,进行服务端的轮询)
									ws = new WebSocket('wss://s1.imlazy.ink:8848');
									//别乱连，不然会炸，，，，
									ws.onerror = () => {
                						Toast.fire({
  										icon: 'error',
  										title: 'Websocket 连接失败！'
										});
            						};
									//连接上来的时候
									ws.onopen = () => {
                						let data = {
                    						type: 'setName',
                    						nickname: sucMsg.selectedProfile.name,
											usertoken: sucMsg.accessToken,
                						};
                						ws.send(JSON.stringify(data));
            						};
           						 	
									//当接受服务端的请求的时候
									ws.onmessage = (e) => {
										var ele = document.getElementById('content');
										ele.scrollTop = ele.scrollHeight;

                						let data = JSON.parse(e.data);
                 						//console.log(data);
                						//接受的消息为连接的人的个数的时候
                						if (data.type === 'chatterList') {
                    						let list = data.list;
                    						let length = list.length;
                    						//let userList = document.getElementById('userList');
                    						document.getElementById('online').innerText = `${length}`;

                    						//for(let i=0;i<list.length;i++){
                        					//	let p_user = document.createElement('p');
                        					//	p_user.setAttribute('class','userList-item');
                       						//	p_user.innerText = list[i].name;
                        					//	userList.appendChild(p_user)
                    						//}
               							}

                						//当为接受消息的或者用户进入新房间的时候
                						else {
											let message = data.message;
                    						let oldContent = document.getElementById('content');
											//console.log(createChatDiv(data));
											const JoinRoom = {
   			 									text: message,
    											color: '#fff',
    											type: 'right',
											};
											dp.danmaku.draw(JoinRoom);
                    						oldContent.appendChild(createChatDiv(data));
                						}

            						};

									ws.onclose = () => {
                						Swal.fire({
    										icon: 'error', 
    										title: '错误', 
    										text: "Websocket连接异常，聊天、弹幕功能将不可用！请刷新网页！",       
    										cancelButtonText: "取消", 
    										focusCancel: true, 
										})
            						};
      							},
								error: function(errMsg){
									console.log(errMsg);
									Swal.fire({
    									icon: 'error', 
    									title: '登录失败', 
    									text: "请检查你的用户名和密码！",       
    									cancelButtonText: "取消", 
    									focusCancel: true, 
									})
      							}
   							});
  						}
					})

					//if (formValues) {
  					//	Swal.fire(JSON.stringify(formValues))
					//}
				})()
  							
			};
			
		</script>
		<script type="text/javascript" language="JavaScript">
        	//定义全局的变量
        	let ws = null;

        	//封装获取时间的函数
       	 	Date.prototype.Format = function (fmt) {
            	var o = {
                	"M+": this.getMonth() + 1, //月份
               		"d+": this.getDate(), //日
                	"h+": this.getHours(), //小时
                	"m+": this.getMinutes(), //分
                	"s+": this.getSeconds(), //秒
                	"q+": Math.floor((this.getMonth() + 3) / 3), //季度
                	"S": this.getMilliseconds() //毫秒
            	};
            	if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
            	for (var k in o)
                if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
            	return fmt;
        	};

        	//封装创建Div并且发送消息的函数
        	const createChatDiv = (data)=> {
            	let div = document.createElement('div');
            	let p_time = document.createElement('b');
				//let p_img = document.createElement('img');
            	let p_content = document.createElement('span');
            	switch (data.type) {
                	case 'serverInformation':
                  	  	p_time.innerHTML = new Date().Format("hh:mm:ss")+"&nbsp;";
                    	p_content.innerHTML = data.message;
                    	break;
                	case  'chat':
						// 聊天区头像
                    	p_time.innerHTML = "<img src=https://www.fxcraft.cn/avatar/player/"+data.name+"?size=16>&nbsp;"+data.name+"：";
                    	p_content.innerHTML = data.message;
                    	break;
                	default:
                    	break;
            	}
			
				div.setAttribute('class' ,'msg');
            	//p_time.setAttribute('class' ,'time');
           		//p_content.setAttribute('class','content');
            	div.appendChild(p_time);
            	div.appendChild(p_content);
            	return div;
        	};
		
			//发送消息
			function keyup_submit(e){ 
 				var evt = window.event || e; 
  				if (evt.keyCode == 13){
					let message = document.getElementById('comment');
           			//设置不能够发送空消息
            		if(!message.value){
               			return
            		}
					var clear_msg = $('#comment').val().replace(/</g,"&lt;").replace(/>/g,"&gt;");
            		let data = {
                		type:'chat',
                		message:clear_msg
            		};
            		ws.send(JSON.stringify(data));
            		message.value = ""
  				}
			}

			// 自动清空聊天栏，估计没用
			var msgcontent = document.getElementById("msgcontent");
			if (msgcontent.innerHTML.length >= 100000) {
				msgcontent.innerHTML ="<div class='msg'><b>SYSTEM：</b><span>已自动清除聊天区</span></div>";
      		}

    	</script>
	</body>
</html>