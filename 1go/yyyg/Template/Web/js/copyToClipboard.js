function copyText(obj){
  try{
      var rng = document.body.createTextRange();
      rng.moveToElementText(obj);
      rng.scrollIntoView();
      rng.select();
      rng.execCommand("Copy");
      rng.collapse(false);
      layer.msg('已经复制到粘贴板!你可以使用Ctrl+V 贴到需要的地方去了哦!', {icon: 2,shade:0.8});
  }catch(e){
      layer.msg('您的浏览器不支持此复制功能，请选中相应内容并使用Ctrl+C进行复制!', {icon: 2,shade:0.8});
  }
}