<?php
include_once('define.php');
require_once(ROOT_PATH . 'include' . DS . 'config' . DS . 'global.php');
require_once(ROOT_PATH . 'include' . DS . 'config' . DS . 'config.legend.php');
require_once("./blocks/html_head.php");

$css_type = Browser::getPlatform() == 'windows' ? 'pc' : 'mobile';
$css_type = 'mobile';
?>
<body>
<link rel="stylesheet" type="text/css" href="/blocks/<?= $css_type ?>.css?<?= time() ?>">
<script type="text/javascript">
    $(function () {
        alert($(window).height());
        alert($(window).width());
        
        var info = {};
        info.type = {
            'all': '全部',
            'book': '书籍',
            //'toy': '玩具',
            //'cloth': '衣物',
            'other': '其它'
        };
        
        info.age = {
            'all': '全部',
            '0-3': '0-3岁',
            '3-6': '3-6岁',
            '6-12': '6-12岁',
            '12+': '12岁以上'
        };

        info.location = {
            //'all': '全部',
            'macheng': '麻城',
            'internet': '网上'
        };

        for (var k in info) {
            for (var k2 in info[k]) {
                $('#row_' + k).append(
                    "<button comment='" + k2 + "'>" + info[k][k2] + "</button>"
                );
            }
        }
    })
</script>

<div class="wrapper">
    <h2>请在点击下面的方块以确定您分享的资源的关键字</h2>
    <table>
        <tr>
            <td id="first_td">资源类型</td>
            <td id="row_type" class="keyWordsContainer">
            
            </td>
        </tr>
        <!--<tr class="empty"></tr>-->
        
        <tr>
            <td>适用年龄</td>
            <td id="row_age" class="keyWordsContainer">
            
            </td>
        </tr>

        <tr>
            <td>资源所在的位置</td>
            <td id="row_location" class="keyWordsContainer">

            </td>
        </tr>
        <tr class="location_detail hidden">
            <td>更详细的位置</td>
            <td>
                <input type="text" name="location_detail" style="width: 90%"
                       placeholder="例如：疾控中心[大致位置即可]"/>
            </td>
        </tr>
        <tr class="location_network hidden">
            <td>网址</td>
            <td>
                <input type="text" name="location_detail" style="width: 90%"
                       placeholder="例如：http://www.126.com"/>
            </td>
        </tr>

        <tr>
            <td>资源名称</td>
            <td>
                <input type="text" name="name" style="width: 90%"
                       placeholder="请输入您要分享的资源的名称"/>
            </td>
        </tr>

        <tr>
            <td>备注</td>
            <td>
                <textarea name="commnet" id="" style=""
                          placeholder="您可以在这里输入一些备注信息"></textarea>
            </td>

        </tr>

        <tr>
            <td colspan="2">
                <button class='submit' type="submit">提交</button>
            </td>
        </tr>
    </table>

    <script>
        $(function () {
            $('#row_location button').click(function () {
                $('.hidden').hide();
                var ss = $(this).text();
                if (ss == '麻城') $('.location_detail').show();
                if (ss == '网上') $('.location_network').show();
            })
        })
    </script>

</div>
</body>
