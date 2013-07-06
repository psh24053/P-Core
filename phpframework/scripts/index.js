$(document).ready(function(){
	
	
	
	initEvent();
	initCSS();
	/* $(document).tooltip({
		  show: null,
	      position: {
	    	  my: "center bottom-10",
	          at: "center top",
	    	  using: function( position, feedback ) {
		          $( this ).css( position );
		          $( "<div>" )
		            .addClass( "arrow" )
		            .addClass( feedback.vertical )
		            .addClass( feedback.horizontal )
		            .appendTo( this );
		        }
	      },
	      open: function( event, ui ) {
	        ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
	      }
	      
	      
	      
	}); */
	$(document).tooltip();
	$('#work_type').buttonset();
	loadWorkList();
	
});
/**
 * 初始化ueditor
 */
function initUEditor(){
	
	var ue_content = UE.getEditor('addprocess_dialog_content');

	ue_content.addListener('ready',function(){
        this.focus()
    });
	
}
/**
 * 加载work列表
 */
function loadWorkList(){
	var wait = new mytask.WaitAlert();
	wait.show();
	
	mytask.action_100_getworklist({
		success: function(data){
			
			if(data.res){
				
				console.debug(data);
				var list = data.pld.list;
				var todayunfinished = 0;
				var todaycomplete = 0;
				var cometoanend = 0;
				var history = 0;
				
				$('.work_item').remove();
				$('.left_arrow').text('无');
				$('#work_content').html('<h1 style="font-size:50px">请选择work</h1>').css('line-height','300px').css('text-align','center').css('border','1px solid #999999');
				
				
				var checkedid = $('input[name=work_type]:checked').attr('id');
				
				
				
				for(var i = 0 ; i < list.length ; i ++){
					var data_item = list[i];
					
					var div_item = $('<div class="work_item"></div>').attr('workid',data_item.work_id).data('work_item',data_item).click(function(){
						loadProcess($(this).attr('workid'),$(this).data('work_item'));
					});;
					var img = $('<img />').attr('src',data_item.work_img);
					var span = $('<span></span>').css('font-size','16px').text(data_item.work_name);
					var hover = $('<div class="hover"></div>').attr('title',data_item.work_desc);
					var status = $('<span></span>').css('text-align','left').css('text-shadow','#cccccc 1px 1px 0').css('margin-left','5px');
					var target_count = null;
					if(data_item.target_count > 0){
						target_count = $('<span></span>').css('color','white').text(data_item.target_count+' 个目标').css('padding-right','10px').css('float','right').css('text-align','right').css('text-shadow','black 1px 1px 0');
					}
					
					if(!data_item.work_img){
						img.attr('src','images/notimg.png');
						span.css('top','-60%').css('font-size','20px');
						hover.css('top','-250px');
						status.css('top','-115%');
						if(target_count != null){
							hover.css('top','-270px');
							target_count.css('top','-125%');
						}
					}else{
						hover.css('top','-244px');
						status.css('top','-112%');
						if(target_count != null){
							hover.css('top','-264px');
							target_count.css('top','-122%');
						}
					}
					switch (data_item.work_status) {
					case '1':
						status.text('等待处理').css('color','red');
						
//						console.debug(data_item,(new Date().getTime() / 1000 - data_item.work_lasttime),new Date().getTime() / 1000,60 * 60 * 24);
						if(data_item.work_everyday == '1' && new Date().setHours(8, 0, 0, 0) / 1000 > data_item.work_lasttime ){
							todayunfinished ++;
							if(checkedid == 'today_unfinished'){
								div_item.append(img).append(span).append(status);
								
								if(target_count != null){
									div_item.append(target_count);
								}
								
								div_item.append(hover);
								$('.item_content').append(div_item);
							}
							
							
						}else{
							todaycomplete ++;
							if(checkedid == 'today_complete'){
								div_item.append(img).append(span).append(status);
								
								if(target_count != null){
									div_item.append(target_count);
								}
								
								div_item.append(hover);
								$('.item_content').append(div_item);
							}
						}
						break;
					case '2':
						status.text('告一段落').css('color','orange');
						cometoanend ++;
						if(checkedid == 'come_to_an_end'){
							div_item.append(img).append(span).append(status);
							
							if(target_count != null){
								div_item.append(target_count);
							}
							
							div_item.append(hover);
							$('.item_content').append(div_item);
						}
						break;
					case '3':
						status.text('成为历史').css('color','fuchsia');
						history ++;
						if(checkedid == 'history'){
							div_item.append(img).append(span).append(status);
							
							if(target_count != null){
								div_item.append(target_count);
							}
							
							div_item.append(hover);
							$('.item_content').append(div_item);
						}
						break;
					case null:
						status.text('未知状态').css('color','black');
						break;
					default:
						break;
					}
					
					
				}
				$('.item_content').find('.work_item:gt(3)').addClass('righthide_item').hide();
				if($('.work_item').size() > 4){
					$('.right_arrow').text('>>');
				}else{
					$('.right_arrow').text('无');
				}
				$('label[for=today_unfinished] span').text('今日待办 （今天 '+todayunfinished+'）');
				$('label[for=today_complete] span').text('等待处理 （所有 '+todaycomplete+'）');
				$('label[for=come_to_an_end] span').text('告一段落 （ '+cometoanend+'）');
				$('label[for=history] span').text('成为历史 （ '+history+'）');
			}
			
			wait.close();
		},
		error: function(err){
			console.debug(err);
			wait.close();
		},
		start: 0,
		count: 100
	});
	
}
/**
 * 初始化CSS样式
 */
function initCSS(){
	
	$('.item_content').css('width',$('#work').width() - 74);
	$('#work_content').html('<h1 style="font-size:50px">请选择work</h1>').css('line-height','300px').css('text-align','center').css('border','1px solid #999999');
}
/**
 * 编辑work
 * @param workid
 * @param work_item
 */
function editWork(workid, work_item){
	
	$('.editwork_dialog').dialog({
		modal: true,
		title: '编辑Work',
		resizable: false,
		width: $(window).width() * 0.5,
	    height: $(window).height() * 0.98,
	    close: function(event, ui){
	    	
	    },
	    open: function(){
	    	$('.editwork_dialog').find('input[name=name]').val(work_item.work_name);
	    	$('.editwork_dialog').find('input[name=file]').val('');
	    	$('.editwork_dialog').find('textarea[name=desc]').val(work_item.work_desc);
    		$('.editwork_dialog').find('select[name=status] option').each(function(){
    			
    			if($(this).val() == work_item.work_status){
    				$(this).attr('selected','selected');
    			}
    			
    		});
    		if(work_item.work_everyday == '1'){
    			$('.editwork_dialog').find('.work_everyday').attr('checked','checked');
    		}else{
    			$('.editwork_dialog').find('.work_everyday').removeAttr('checked');
    		}
    		$('.editwork_dialog').find('.addwork_img').attr('src',work_item.work_img);
	    },
	    create: function(){
	    	$('.addwork_img').attr('title','点击清除图片').css('width',$('.item_content').width() * 0.238).css('height',200).click(function(){
	    		$(this).attr('src','#');
	    	});
	    },
	    buttons: {
	    	'编辑': function(event,ui){
	    		var work_name = $('.editwork_dialog').find('input[name=name]').val();
	    		var work_desc = $('.editwork_dialog').find('textarea[name=desc]').val();
	    		var work_status = $('.editwork_dialog').find('select[name=status]').val();
	    		var work_img = $('.editwork_dialog').find('.addwork_img').attr('src');
	    		var everyday = $('.editwork_dialog').find('.work_everyday').attr('checked') ? 1 : 0;
	    		if(work_img == undefined || work_img == '#'){
	    			work_img = '';
	    		}
	    	
	    		if(!work_name){
	    			alert('请填写work名称');
	    			return;
	    		}
	    		if(!work_desc){
	    			alert('请填写work描述');
	    			return;
	    		}
	    		mytask.action_105_editwork({
	    			success: function(data){
	    				if(data.res){
	    					alert('编辑work成功！');
	    					loadWorkList();
	    					$('.editwork_dialog').dialog('close');
	    					$('.editwork_dialog').find('.addwork_img').attr('src','');
	    				}else{
	    					alert('编辑work失败！');
	    				}
	    			},
	    			error: function(err){
	    				alert('执行错误！err:'+err);
	    			},
	    			name: work_name,
	    			desc: work_desc,
	    			status: work_status,
	    			img: work_img,
	    			id: workid,
	    			everyday: everyday
	    		});
	    		
	    	},
	    	'取消': function(){
	    		$(this).dialog('close');
	    	},
	    	'删除': function(){
	    		mytask.Confirm('你真的要删除这个work吗？','删除确认',function(result){
	    			if(result){
	    				mytask.action_106_delwork({
	    					success: function(data){
	    						if(data.res){
	    							alert('删除work成功！');
	    							loadWorkList();
	    	    					$('.editwork_dialog').dialog('close');
	    	    					$('.editwork_dialog').find('.addwork_img').attr('src','');
	    						}
	    					},
	    					error: function(err){
	    						alert('执行错误！err:'+err);
	    					},
	    					workid: workid
	    				});
	    			}
	    		});
	    	}
	    }
	});
}
/**
 * 增加target
 * @param workid
 */
function addTarget(workid){
	$('.addtarget_dialog').dialog({
		modal: true,
		title: '增加target',
		resizable: false,
		width: $(window).width() * 0.5,
	    height: $(window).height() * 0.4,
	    close: function(event, ui){
	    	
	    },
	    open: function(){
	    	$('.addtarget_dialog [name=content]').val('');
	    },
	    buttons: {
	    	'增加': function(){
	    		var content = $('.addtarget_dialog [name=content]').val();
	    		
	    		if(content == undefined || content == ''){
	    			alert('请填写内容');
	    			return;
	    		}
	    		
	    		mytask.action_109_addtarget({
	    			success: function(data){
	    				if(data.res){
	    					$('.addtarget_dialog').dialog('close');
	    					alert('增加target成功！');
	    					loadProcess(workid, $('.work_item[workid='+workid+']').data('work_item'));
	    				}
	    				
	    			},
	    			error: function(err){
	    				alert('执行错误！'+err);
	    			},
	    			workid: workid,
	    			content: content
	    			
	    		});
	    	},
	    	'取消': function(){
	    		$(this).dialog('close');
	    	}
	    }
	});
}
/**
 * 加载process
 * @param workid
 * @param work_item
 */
function loadProcess(workid,work_item){
	$('.focus_work').removeClass('focus_work');
	$('.work_item[workid='+workid+']').addClass('focus_work');
	$('#work_content').html('').css('line-height','').css('text-align','').css('border','none').css('border-top','1px solid #999999');
	
	var workinfo = $('<div class="work_info" title="点击编辑"></div>').click(function(){
		editWork(workid, work_item);
	});
	var worktitle = $('<div class="work_title"></div>').text(work_item.work_name).appendTo(workinfo);
	var workstatus = $('<div class="work_status"></div>').appendTo(workinfo);
	switch (work_item.work_status) {
	case '1':
		workstatus.text('等待处理').css('color','red');
		break;
	case '2':
		workstatus.text('告一段落').css('color','orange');
		break;
	case '3':
		workstatus.text('成为历史').css('color','fuchsia');
		break;
	case null:
		workstatus.text('未知状态').css('color','black');
		break;
	default:
		break;
	}
	var workcreatetime = $('<div class="work_createtime"></div>').text('创建于'+work_item.work_createtimevalue).appendTo(workinfo);
	$('#work_content').append(workinfo);

	var processlist = $('<div class="process_list"></div>');
	
	var	targetlist = $('<div class="targetlist"></div>').appendTo(processlist);
	
	$('<div class="process_target target_add">+ 新增目标</div>').appendTo(targetlist).click(function(){
		addTarget(workid);
	});
	
	var processadd = $('<div class="process_add">+ 新增process</div>').appendTo(processlist).click(function(){
		addProcess(workid);
	});
	
	
	
	$('#work_content').append(processlist);
	mytask.action_107_gettargetlist({
		success: function(data){
			if(data.res){
				var list = data.pld.list;
				
				for(var i = 0 ; i < list.length ; i ++){
					var data_item = list[i];
					var target = $('<div class="process_target"></div>').attr('targetid',data_item.target_id).text('目标 '+(i+1)+' : '+data_item.target_content).appendTo($('.targetlist'));
					target.click(function(){
						var ppthis = $(this);
						mytask.Confirm('该目标完成了吗？',null,function(result){
							if(result){
								mytask.action_108_updatetargetstatus({
									success: function(data){
										if(data.res){
											alert('更新target状态成功！');
											loadProcess(workid, work_item);
											
										}else{
											alert('更新target状态失败！');
										}
									},
									error: function(err){
										alert('执行错误！'+err);
									},
									targetid: ppthis.attr('targetid')
								});
							}
						});
					});
				}
				
			}
		},
		error: function(err){
			alert('执行操作!'+err);
		},
		start: 0,
		count: 1000,
		workid: workid
	});
	mytask.action_102_getprocesslist({
		success: function(data){
			if(data.res){
				var list = data.pld.list;
				for(var i = 0 ; i < list.length ; i ++){
					var data_item = list[i];
					var processitem = $('<div class="process_item"></div>').attr('processid',data_item.process_id).data('process_item',data_item);
					var processtime = $('<div class="process_time" ></div>').appendTo(processitem).text(data_item.process_timevalue).attr('title',data_item.process_time);
					var processcontent = $('<div class="process_content"></div>').attr('title',data_item.process_desc).appendTo(processitem);
					var processcontentvalue = $('<span class="content_value"></span>').appendTo(processcontent).html(data_item.process_content);
					var processbuttons = $('<div class="process_buttons"></div>').appendTo(processcontent);
					var processdelbutton = $('<a href="javascript:void(0)">删除</a>').attr('processid', data_item.process_id).appendTo(processbuttons).click(function(){
						var pthis = this;
						
						mytask.Confirm('是否要删除这个process？','删除确认',function(result){
							if(result){
								
								mytask.action_104_delprocess({
									success: function(data){
										if(data.res){
											alert('删除成功！');
											loadProcess(workid, work_item);
										}
									},
									error: function(err){
										alert('操作失败！'+err);
									},
									processid: $(pthis).attr('processid')
								});
							}
						});
						
						
					});
					
					
					processitem.mouseover(function(){
						$(this).find('.process_buttons').show();
					}).mouseout(function(){
						$(this).find('.process_buttons').hide();
					});
					
					if(i == list.length - 1){
						processitem.css('border-color','#999999');
					}
					
					processlist.append(processitem);
				}
				
				
			}
		},
		error: function(err){
			alert(err);
		},
		start: 0,
		count: 1000,
		workid: workid
	});
	
}
/**
 * 增加process
 * @param workid
 */
function addProcess(workid){
	
	$('.addprocess_dialog').dialog({
		modal: true,
		title: '增加Process',
		resizable: false,
		width: $(document).width() * 0.8,
	    height: $(window).height(),
	    close: function(event, ui){
	    	
	    },
	    open: function(){
	    	UE.getEditor('addprocess_dialog_content').setContent('',false);
	    	$('.addprocess_dialog').find('textarea[name=desc]').val('');
	    },
	    create: function(){
	    	initUEditor();
	    },
	    buttons: {
	    	'增加': function(event,ui){
	    		
	    		var process_content = UE.getEditor('addprocess_dialog_content').getContent();
	    		var process_desc = $('.addprocess_dialog').find('textarea[name=desc]').val();
	    	
	    		if(!process_content){
	    			alert('请填写process内容');
	    			return;
	    		}
	    		mytask.action_103_addprocess({
	    			success: function(data){
	    				if(data.res){
	    					alert('增加process成功！');
//	    					loadWorkList();
	    					loadProcess(workid, $('.work_item[workid='+workid+']').data('work_item'));
	    					$('.addprocess_dialog').dialog('close');
	    				}else{
	    					alert('增加process失败！');
	    				}
	    			},
	    			error: function(err){
	    				alert('执行错误！err:'+err);
	    			},
	    			content: process_content,
	    			desc: process_desc,
	    			workid: workid
	    		});
	    		
	    	},
	    	'取消': function(){
	    		$(this).dialog('close');
	    	}
	    }
	});
}
/**
 * 初始化事件
 */
function initEvent(){
	
	$('input[name=work_type]').change(function(){
		loadWorkList();
	});
	
	$('.left_arrow').click(function(){
		if($('.lefthide_item').size() > 0){
			
			$('.work_item:visible').last().addClass('righthide_item').hide();
			$('.lefthide_item').last().removeClass('lefthide_item').show();
			$('.right_arrow').text('>>');
			
			if($('.lefthide_item').size() == 0){
				$('.left_arrow').text('无');
			}
			
		}
	});
	$('.right_arrow').click(function(){
		if($('.righthide_item').size() > 0){
			
			$('.work_item:visible').first().addClass('lefthide_item').hide();
			$('.righthide_item').first().removeClass('righthide_item').show();
			$('.left_arrow').text('<<');
			
			if($('.righthide_item').size() == 0){
				$('.right_arrow').text('无');
			}
		}
	});
	
	
	$('.add_work_button').click(function(){
		addWork();
	});
	$('.refresh_button').click(function(){
		$('#work_content').html('<h1 style="font-size:50px">请选择work</h1>').css('line-height','300px').css('text-align','center').css('border','1px solid #999999');
		loadWorkList();
	});
	
	$('.addworkimg_upload').click(function(){
		var fileval = $(this).parent().find('.mytask-fileinput').val();
		if(fileval == undefined || fileval == ''){
			alert('请选择文件');
			return;
		}
		$(this).parent().submit();
		
	});
}
/**
 * 增加work
 */
function addWork(){
	
	$('.addwork_dialog').dialog({
		modal: true,
		title: '增加Work',
		resizable: false,
		width: $(window).width() * 0.5,
	    height: $(window).height() * 0.98,
	    close: function(event, ui){
	    	
	    },
	    open: function(){
	    	$('.addwork_dialog').find('input[name=name]').val('');
	    	$('.addwork_dialog').find('input[name=file]').val('');
	    	$('.addwork_dialog').find('textarea[name=desc]').val('');
    		$('.addwork_dialog').find('select[name=status]').val('');
    		$('.addwork_dialog').find('.work_everyday').removeAttr('checked');
    		$('.addwork_dialog').find('.addwork_img').attr('src','');
	    },
	    create: function(){
	    	$('.addwork_img').css('width',$('.item_content').width() * 0.238).css('height',200);
	    },
	    buttons: {
	    	'增加': function(event,ui){
	    		var work_name = $('.addwork_dialog').find('input[name=name]').val();
	    		var work_desc = $('.addwork_dialog').find('textarea[name=desc]').val();
	    		var work_status = $('.addwork_dialog').find('select[name=status]').val();
	    		var everyday = $('.addwork_dialog').find('.work_everyday').attr('checked') ? 1 : 0;
	    		var work_img = $('.addwork_dialog').find('.addwork_img').attr('src');
	    		if(work_img == undefined){
	    			work_img = '';
	    		}
	    	
	    		if(!work_name){
	    			alert('请填写work名称');
	    			return;
	    		}
	    		if(!work_desc){
	    			alert('请填写work描述');
	    			return;
	    		}
	    		mytask.action_101_addwork({
	    			success: function(data){
	    				if(data.res){
	    					alert('增加work成功！');
	    					loadWorkList();
	    					$('.addwork_dialog').dialog('close');
	    					$('.addwork_dialog').find('.addwork_img').attr('src','');
	    				}else{
	    					alert('增加work失败！');
	    				}
	    			},
	    			error: function(err){
	    				alert('执行错误！err:'+err);
	    			},
	    			name: work_name,
	    			desc: work_desc,
	    			status: work_status,
	    			img: work_img,
	    			everyday: everyday
	    		});
	    		
	    	},
	    	'取消': function(){
	    		$(this).dialog('close');
	    	}
	    }
	});
	
	
}