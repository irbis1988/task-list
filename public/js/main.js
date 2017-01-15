var App = (function(){
	return {
		addFormValidate: function(cfg){						
			
			var modal = document.getElementById('preview-modal');
			var	previewBut = document.getElementById('preview-but');
			var file = document.getElementsByName('add[image]')[0];
			var altFile = document.getElementsByName('add[altImage]')[0];
			var subm = document.getElementsByName('add[send]')[0];
			var preloader = document.getElementById('for-image');
			var image  = new Image();
			
			previewBut.addEventListener('click',function(){

				document.getElementById('pre-username').innerHTML = document.getElementsByName('add[username]')[0].value;
				document.getElementById('pre-email').innerHTML = document.getElementsByName('add[email]')[0].value;
				document.getElementById('pre-text').innerHTML = document.getElementsByName('add[text]')[0].value;
				document.getElementById('pre-image').src = image.src;

				modal.setAttribute('class', modal.getAttribute('class').replace('fade','show'));
			});

			document.querySelector('.modal .close, #preview-modal').addEventListener('click',function(){
				modal.setAttribute('class', modal.getAttribute('class').replace('show','fade'));
			});			
			
			Image.prototype.resize = function(type){ 
				if (this.width > cfg.maxWidth) {
					var canvas = document.createElement("canvas");
					
					var ctx = canvas.getContext("2d");
					ctx.drawImage(this, 0, 0);

					var width = this.width;
					var height = this.height;

					if (width > height) {
						if (width > cfg.maxWidth) {
							height *= cfg.maxWidth / width;
							width = cfg.maxWidth;
						}
					} else {
						if (height > cfg.maxHeight) {
							width *= cfg.maxHeight / height;
							height = cfg.maxHeight;
						}
					}
					canvas.width = width;
					canvas.height = height;
					var ctx = canvas.getContext("2d");
					ctx.drawImage(this, 0, 0, width, height);

					this.src = canvas.toDataURL(type);
					return true;
				}else{
					return false;
				}
			};
			
			file.addEventListener("change", function(){
				
				preloader.style.display = 'block';
				function submitLocker(e){
					e.preventDefault();
				}
				subm.addEventListener('click',submitLocker);
				
				var files = file.files;
				
				if (files.length > 0) {
					
					if(cfg.types.indexOf(files[0].type)===-1){
						file.setCustomValidity(cfg.typeMess);
						return;
					}else if (files[0].size > cfg.fSize) {
						console.log(1);
						file.setCustomValidity("Максимальный размер загружаемого файла " 
							+ Math.round(cfg.fSize/1024) + " KB");
						return;
					}else{
					
						var reader = new FileReader();
						
						
						reader.addEventListener("load", function () {

							image.addEventListener("load", function(){
								if(image.resize(files[0].type)){
									altFile.value = image.src;
								}
								
							});
							image.src = reader.result;
							preloader.style.display='none';
							subm.removeEventListener('click',submitLocker);
						});
						reader.readAsDataURL(files[0]);  
					
					}
				}
				file.setCustomValidity("");				
			});
			
		}
	};
})();
