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
    // wx.request({
    //   url: 'http://www.tp5.com/api/v1/banner/'+id,
    //   method: 'GET',
    //   success: function(res) {
    //     callBack(res);
    //   }
    // })
  }
} export {Home};