import { Base } from '../../utils/base.js';

class Home extends Base{
  constructor(){
    super();
  }

  getBannerData(id,callBack){
    var params = {
      url:'/banner/'+id,
      sCallBack:function(res){
        callBack && callBack(res);
      }
    }
    this.request(params);

  }
  getThemeData(callBack) {
    var params = {
      url: '/theme?ids=1,2',
      sCallBack: function (res) {
        callBack && callBack(res);
      }
    }
    this.request(params);
  }
  getThemeFullData(callBack) {
    var params = {
      url: '/theme?ids=3',
      sCallBack: function (res) {
        callBack && callBack(res);
      }
    }
    this.request(params);
  }  
} export {Home};