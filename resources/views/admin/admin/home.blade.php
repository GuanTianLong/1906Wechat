@extends('layouts.app')

@section('title', '一周气温展示')

@section('content')

    <h3 align="center" style="color:red">❤❤<b style="color:black">一周气温展示</b>❤❤</h3><hr>

    城市：<input type="text" name="city" id="city" style="height:32px;" placeholder="请输入城市名称...">
    <button class="btn btn-info" id="search">搜索</button><b style="color:red">【城市名必须为汉字】</b>

    <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>

    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <script src="/jquery.js"></script>

    <script>
        //一进入当前页面，默认展示北京天气

        $(document).ready(function(){
            var city = "北京";
            //通过ajax技术将城市名称传给控制器
            $.ajax({
                method: "GET",
                url: "{{url('/admin/getWeather')}}",
                data: {city:city},
            }).done(function(res) {
                weather(res.result);
            });
        })
            //为搜索按钮绑定一个点击事件
            $(document).on("click","#search",function(){
                //alert(1111);

                //获取文本框的值------城市名
                //var city = $('[name="city"]').val();
                var city = $('#city').val();
                //console.log(city);

                //正则
                var reg = /^[\u4e00-\u9fa5]{2,}$/;
                //判断及验证
                if(city==''){
                    alert('请输入城市名称');
                }else if(!reg.test(city)){
                    alert('城市名称必须是汉字，至少2位');
                }

                //通过ajax技术将城市名称传给控制器
                $.ajax({
                    method: "GET",
                    url: "{{url('/admin/getWeather')}}",
                    data: {city:city},
                }).done(function(res) {
                    weather(res.result);
                });
            });

            function weather(weatherData){
                //console.log(weatherData);

                //x轴日期
                var categories = [];

                //x轴对应的最高最低气温
                var data = [];

                $.each(weatherData,function(i,v){
                    categories.push(v.days);

                    var arr = [parseInt(v.temp_low),parseInt(v.temp_high)];
                    //console.log(categories);
                    data.push(arr);

                });

                var chart = Highcharts.chart('container', {
                    chart: {
                        type: 'columnrange', // columnrange 依赖 highcharts-more.js
                        inverted: true
                    },
                    title: {
                        text: '一周天气气温'
                    },
                    subtitle: {
                        text: weatherData[0]['citynm']
                    },
                    xAxis: {
                        categories:categories
                    },
                    yAxis: {
                        title: {
                            text: '温度 ( °C )'
                        }
                    },
                    tooltip: {
                        valueSuffix: '°C'
                    },
                    plotOptions: {
                        columnrange: {
                            dataLabels: {
                                enabled: true,
                                formatter: function () {
                                    return this.y + '°C';
                                }
                            }
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    series: [{
                        name: '温度',
                        data: data
                    }]
                });
            }

    </script>
@endsection