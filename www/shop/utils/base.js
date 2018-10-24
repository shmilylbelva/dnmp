import { Config } from '../utils/config.js';

class Base {
  constructor(){
    this.baseUrl = Config.restUrl;
  }
  request(params){
    var url = this.baseUrl + params.url;
    wx.request({
      url: url,
      data: params.data,
      header: {
        'content-type':'application/json',
        'token':wx.getStorageSync('token')
      },
      method: params.type || 'GET',
      dataType: params.type || 'json',
      responseType: params.responseType || 'text',
      success: function (res) { 
        params.sCallBack&&params.sCallBack(res);   
      },
      fail: function (res) { 

      },
      complete: function (res) { },
    })
  }

}