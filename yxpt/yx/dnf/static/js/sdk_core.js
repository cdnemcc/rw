sdkBase = '//www.7zgm.com/';

var paramsInfo, ws;
var messageHandler=function(e) {
	if (e.data.op == 'pay') {
		e.data.params.game_id = game_id;
		e.data.params.channel_id = channel_id;
		paramsInfo = e.data.params;

		if (navigator.userAgent.match(/MicroMessenger/i)) {
			if (typeof user_xinpianchang_udid == 'undefined') {
				ajaxPost(sdkBase + 'pay/wechat', JSON.stringify(e.data.params), function(data) {
					if (data.msg == 0) {
						function onBridgeReady() {
							WeixinJSBridge.invoke('getBrandWCPayRequest', {
								"appId": data.body.appId,
								"timeStamp": data.body.timeStamp,
								"nonceStr": data.body.nonceStr,
								"package": data.body.package,
								"signType": data.body.signType,
								"paySign": data.body.paySign
							},
							function(res) {
							   if(res.err_msg == "get_brand_wcpay_request：ok" ) {}
							});
						}
						if (typeof WeixinJSBridge == "undefined") {
							if(document.addEventListener) {
								document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
							} else if (document.attachEvent) {
								document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
								document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
							}
						} else {
						   onBridgeReady();
						}
					} else {
						layer.msg(data.body, {icon: 5, offset: 't', shift: 6, shade: 0.8});
					}
				});
			} else {
				
			}
		} else {
			if (getCookie('user_auto_regist') == 1) {
				//处理试玩用户的逻辑
				layer.open({
					type: 1, 
					content: $('#account-login'), 
					skin: 'loginbox',
					closeBtn: 1, 
					shade: 0.3, 
					title: false });


			} else {
				chose_pay(paramsInfo.name, paramsInfo.price);
			}
		}
	}
	else if (e.data.op == 'pay_gm') {
		e.data.params.game_id = game_id;
		e.data.params.channel_id = channel_id;
		paramsInfo = e.data.params;
		if (getCookie('user_auto_regist') == 1) {
			//处理试玩用户的逻辑
			layer.open({
				type: 1,
				content: $('#account-login'),
				skin: 'loginbox',
				closeBtn: 1,
				shade: 0.3,
				title: false });


		} else {
			chose_pay(paramsInfo.name, paramsInfo.price);
		}
	}
	else if (e.data.op == 'alipay') {
		ajaxPost(sdkBase + 'pay/alipay', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				$('#paylistframe').show();
			} else {
				layer.msg('支付宝支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	// else if (e.data.op == 'wxwap') {
	// 	ajaxPost(sdkBase + 'pay/wxwap', JSON.stringify(paramsInfo), function(data) {
	// 		if (data.msg == 0) {
	// 			window.location = data.body;
	// 			// $(document.getElementById('paylistframe')).attr('src', data.body);
	// 			// $('#paylistframe').show();
	// 		} else {
	// 			layer.msg('微信支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
	// 		}
	// 	});
	// }
	else if (e.data.op == 'wxwap') {
		ajaxPost(sdkBase + 'pay/wxwap', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
			} else {
				//layer.msg(data.body, {icon: 5, offset: 't', shift: 6, shade: 0.8});
				layer.msg('微信支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	else if (e.data.op == 'scan') {
		ajaxPost(sdkBase + 'pay/scan', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				$('#paylistframe').show();
			} else {
				layer.msg('微信扫码支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	else if (e.data.op == 'ty_wxscan') {
		ajaxPost(sdkBase + 'pay/ty_wxscan', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				$('#paylistframe').show();
			} else {
				layer.msg('微信扫码支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	else if (e.data.op == 'ty_wxwap') {
		ajaxPost(sdkBase + 'pay/ty_wxwap', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				$('#paylistframe').show();
			} else {
				layer.msg('微信扫码支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	else if (e.data.op == 'ty_aliscan') {
		ajaxPost(sdkBase + 'pay/ty_aliscan', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				$('#paylistframe').show();
			} else {
				layer.msg('支付宝支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}	
	else if (e.data.op == 'ty_aliwap') {
		ajaxPost(sdkBase + 'pay/ty_aliwap', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				$('#paylistframe').show();
			} else {
				layer.msg('支付宝支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}

	else if (e.data.op == 'ty_wxscan') {
		ajaxPost(sdkBase + 'pay/ty_wxscan', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				$('#paylistframe').show();
			} else {
				layer.msg('微信扫码支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	else if (e.data.op == 'ty_wxwap') {
		ajaxPost(sdkBase + 'pay/ty_wxwap', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				$('#paylistframe').show();
			} else {
				layer.msg('微信扫码支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	else if (e.data.op == 'ty_aliscan') {
		ajaxPost(sdkBase + 'pay/ty_aliscan', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				$('#paylistframe').show();
			} else {
				layer.msg('支付宝支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	else if (e.data.op == 'ty_aliwap') {
		ajaxPost(sdkBase + 'pay/ty_aliwap', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				$('#paylistframe').show();
			} else {
				layer.msg('支付宝支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}



	else if (e.data.op == 'gm_ty_wxscan') {
		ajaxPost(sdkBase + 'gmpay/ty_wxscan', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.body).append(data.body);
			} else {
				layer.msg('微信扫码支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	else if (e.data.op == 'gm_ty_wxwap') {
		ajaxPost(sdkBase + 'gmpay/ty_wxwap', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.body).append(data.body);
			} else {
				layer.msg('微信扫码支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	else if (e.data.op == 'gm_ty_aliscan') {
		ajaxPost(sdkBase + 'gmpay/ty_aliscan', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.body).append(data.body);
			} else {
				layer.msg('支付宝支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	else if (e.data.op == 'gm_ty_aliwap') {
		ajaxPost(sdkBase + 'gmpay/ty_aliwap', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 0) {
				$(document.body).append(data.body);
			} else {
				layer.msg('支付宝支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	
	else if (e.data.op == 'kj_aliwap') {
		ajaxPost(sdkBase + 'pay/kj_aliwap', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 1) {
				//$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				//$('#paylistframe').show();
				window.location=data.body;
			} else {
				//layer.msg('支付宝支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
				layer.msg(data.body, {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	
	else if (e.data.op == 'kj_all') {
		ajaxPost(sdkBase + 'pay/kj_all', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 1) {
				//$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				//$('#paylistframe').show();
				//window.location=data.body;
				$("#p_code").html(data.body);
			} else {
				//layer.msg('支付宝支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
				layer.msg(data.body, {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}
	
	else if (e.data.op == 'kj_weixin') {
		ajaxPost(sdkBase + 'pay/kj_weixin', JSON.stringify(paramsInfo), function(data) {
			if (data.msg == 1) {
				//$(document.getElementById('paylistframe').contentWindow.document.body).append(data.body);
				//$('#paylistframe').show();
				//window.location=data.body;
				$("#p_code").html(data.body);
			} else {
				//layer.msg('支付宝支付暂不可用', {icon: 5, offset: 't', shift: 6, shade: 0.8});
				layer.msg(data.body, {icon: 5, offset: 't', shift: 6, shade: 0.8});
			}
		});
	}	

	else if (e.data.op == 'back') {
		$("#paylistframe").hide();
		layer.msg('支付完成', {icon: 1, offset: 't', time: 1000, shade: 0.8});
	}
	else if (e.data.op == 'roleinfo') {
		e.data.params.game_id = game_id;
		paramsInfo = e.data.params;
		ajaxPost(sdkBase + 'user/role_info', JSON.stringify(paramsInfo), function(data) {
			// if (data.msg == 0) {
			// } else {
			// 	layer.msg('上传角色信息失败', {icon: 5, offset: 't', shift: 6, shade: 0.8});
			// }
		});
	}
	else if (e.data.op == 'userinfo') {
		var res = {
		    account: getCookie('user_account'),
		    nickname: getCookie('user_nickname'),
		    avatar: getCookie('user_avatar')
		};
		var data = {op: 'onuserinfo', value: JSON.stringify(res)};
		document.getElementById('fwgameframe').contentWindow.postMessage(data,'*');
	}
	else if (e.data.op == 'follow') {
		follow();
	}
	// else if (e.data.op == 'share') {
	// 	window.addEventListener('message',function(e){
	// 		if (e.data.value.status == 1) {
	// 			return true;
	// 		} else {
	// 			return false;
	// 		}
	//     },false);
	// }
}

if (typeof window.postMessage != 'undefined') {
	if(window.addEventListener) {
		window.addEventListener('message', messageHandler, false);
	} else if (window.attachEvent) {
		window.attachEvent('onmessage',messageHandler);
	}
}

function shareCallBack(type, status) {
	if ($("#fwgameframe").length > 0) {
		var data = {op: 'share', value: {type: type, status: status}};
		document.getElementById('fwgameframe').contentWindow.postMessage(data,'*');
	}
}

function ajaxPost(url, data, func) {
	var v;
	$.ajax({
		type: 'POST',
		url: url,
		cache: false,
		data: data,
		crossdomain: true,
		contentType: 'text/json; charset=utf-8',
		datatType: "json",
		beforeSend: function() {
			v = layer.load(0, {shade: 0.8});
		},
		success: function(data) {
			func(data);
		},
		error: function() {
			layer.msg('请求状态异常，请联系客服');
		},
		complete: function() {
			layer.close(v);
		}
	});
}
