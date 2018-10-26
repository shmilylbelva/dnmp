// pages/home/home.js
import { Home } from 'home-model.js';

var home = new Home();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    images: '',
    theme:'',
    themeFull:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function () {
    this._loadDate();
  },
  _loadDate:function(){
    var id = 1;
    home.getBannerData(id, (res)=>{
      this.setData({
        images: res.data.items
      })     
    });

    home.getThemeData((res) => {
      this.setData({
        theme: res.data
      })
    });    
    home.getThemeFullData((res) => {
      this.setData({
        themeFull: res.data[0]
      })
    });      
  }

})

export { Page };