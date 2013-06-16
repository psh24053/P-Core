/**
 * Ajax工具类
 */
function Ajax(Settings){
	
	this.Servlet = "main.php";
	this.ActionCode = " ";
	this.Method = "post";
	this.prm = {};
	this.Success = function(){};
	this.Error = function(){};
	this.Complete = function(){};
	this.dataType = "json";
	this.data = null;
	this.async = true;
	
	if(Settings){
		for(var key in Settings){
			if(this[key]){
				this[key] = Settings[key];
			}
		}
	}
	for(var key in this.prm){
		if(this.prm[key] == 'null'){
			delete this.prm.key;
		}
	}
	this.RequestJson = {
		cod: this.ActionCode,
		prm: this.prm
	};
	
	var p_this = this;
	
	this.send = function(run){
		if(run != undefined){
			run();
		}
		$.ajax({
			type: this.Method,
			async: this.async,
			url: this.Servlet,
			data: JSON.stringify(this.RequestJson),
			success: function(data){
				this.data = data;

				p_this.Success(data);
				
			},
			dataType: this.dataType
		}).error(this.Error).complete(this.Complete);
	};
	this.set = function(key,value){
		if(this[key]){
			this[key] = value;
		}
	};
	
	
}

/**
 * 获取work列表
 * @cod 100
 * @param start
 * @param count
 * @param success
 * @param error
 * @param before
 */
mytask.action_100_getworklist = function(opts){
	
	new Ajax({
		ActionCode: 100,
		Success: opts.success,
		Error: opts.error,
		prm: {
			start: opts.start,
			count: opts.count
		}
	}).send(opts.before);
};
/**
 * 增加一个work
 * @cod 101
 * @param name
 * @param desc
 * @param status
 * @param img
 * @param success
 * @param error
 * @param before
 */
mytask.action_101_addwork = function(opts){
	
	new Ajax({
		ActionCode: 101,
		Success: opts.success,
		Error: opts.error,
		prm: {
			name: opts.name,
			desc: opts.desc,
			status: opts.status,
			img: opts.img,
			everyday: opts.everyday
		}
	}).send(opts.before);
};
/**
 * 获取process列表
 * @cod 102
 * @param start
 * @param count
 * @param workid
 * @param success
 * @param error
 * @param before
 */
mytask.action_102_getprocesslist = function(opts){
	
	new Ajax({
		ActionCode: 102,
		Success: opts.success,
		Error: opts.error,
		prm: {
			start: opts.start,
			count: opts.count,
			workid: opts.workid
		}
	}).send(opts.before);
};
/**
 * 增加process
 * @cod 103
 * @param name
 * @param desc
 * @param workid
 * @param success
 * @param error
 * @param before
 */
mytask.action_103_addprocess = function(opts){
	
	new Ajax({
		ActionCode: 103,
		Success: opts.success,
		Error: opts.error,
		prm: {
			content: opts.content,
			desc: opts.desc,
			workid: opts.workid
		}
	}).send(opts.before);
};
/**
 * 删除process
 * @cod 104
 * @param processid
 * @param success
 * @param error
 * @param before
 */
mytask.action_104_delprocess = function(opts){
	
	new Ajax({
		ActionCode: 104,
		Success: opts.success,
		Error: opts.error,
		prm: {
			processid: opts.processid
		}
	}).send(opts.before);
};
/**
 * 修改一个work
 * @cod 105
 * @param name
 * @param desc
 * @param status
 * @param img
 * @param id
 * @param success
 * @param error
 * @param before
 */
mytask.action_105_editwork = function(opts){
	
	new Ajax({
		ActionCode: 105,
		Success: opts.success,
		Error: opts.error,
		prm: {
			name: opts.name,
			desc: opts.desc,
			status: opts.status,
			img: opts.img,
			id: opts.id,
			everyday: opts.everyday
		}
	}).send(opts.before);
};
/**
 * 删除一个work
 * @cod 106
 * @param id
 * @param success
 * @param error
 * @param before
 */
mytask.action_106_delwork = function(opts){
	
	new Ajax({
		ActionCode: 106,
		Success: opts.success,
		Error: opts.error,
		prm: {
			workid: opts.workid
		}
	}).send(opts.before);
};
/**
 * 获取target列表
 * @cod 107
 * @param start
 * @param count
 * @param workid
 * @param success
 * @param error
 * @param before
 */
mytask.action_107_gettargetlist = function(opts){
	
	new Ajax({
		ActionCode: 107,
		Success: opts.success,
		Error: opts.error,
		prm: {
			start: opts.start,
			count: opts.count,
			workid: opts.workid
		}
	}).send(opts.before);
};
/**
 * 更新target的状态
 * @cod 108
 * @param id
 * @param success
 * @param error
 * @param before
 */
mytask.action_108_updatetargetstatus = function(opts){
	
	new Ajax({
		ActionCode: 108,
		Success: opts.success,
		Error: opts.error,
		prm: {
			targetid: opts.targetid
		}
	}).send(opts.before);
};
/**
 * 插入target的状态
 * @cod 109
 * @param workid
 * @param content
 * @param success
 * @param error
 * @param before
 */
mytask.action_109_addtarget = function(opts){
	
	new Ajax({
		ActionCode: 109,
		Success: opts.success,
		Error: opts.error,
		prm: {
			workid: opts.workid,
			content: opts.content
		}
	}).send(opts.before);
};
/**
 * 获取errocode列表
 * @cod 900
 * @param success
 * @param error
 * @param before
 */
mytask.action_900_geterrorcodelist = function(opts){
	
	new Ajax({
		ActionCode: 900,
		Success: opts.success,
		Error: opts.error
	}).send(opts.before);
};



