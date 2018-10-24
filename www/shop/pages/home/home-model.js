
class Home{
  constructor(){

  }

  getBannerData(id,callBack){
    wx.request({
      url: 'http://www.tp5.com/api/v1/banner/'+id,
      method: 'GET',
      success: function(res) {
        callBack(res);
      }
    })
  }
} export {Home};