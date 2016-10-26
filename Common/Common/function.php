<?php
/**
 * =================================================
 * @版权所有  好奇吧，并保留所有权利。
 * @网站地址: http://www.haoqiba.com；
 * -------------------------------------------------
 * @这是一个商业软件！您只能在得到官方的授权才可对程序代码进行修改
 * @使用；只允许作为学习参考，不允许对程序代码以任何形式任何目的的再发布。
 * @author		zhong
 * @link		http://www.haoqiba.com；
 * =================================================
*/
/*密码处理*/
if(!function_exists('password'))
{
    function password($password)
    {
    	return md5(md5($password.'lz').'HQB');
    }
}
/*
* $totalRows 总行数
* $listRows 每页显示行数
* $nowPage 当前页
* $rollPage 显示多少页
*/
if(!function_exists('pages'))
{
    function pages($totalRows,$nowPage,$listRows,$rollPage = 5)
    {
        $p = I('request.p');
    	if(0 == $totalRows) return ;
        /* 生成URL */
        if($_SERVER['REQUEST_URI'] == '/'){
            $url = '/p/[PAGE]';
        }elseif(empty($p)){//没有页码时增加页码参数
            $url = $_SERVER['REQUEST_URI'];
            if(strpos($url,'.html?') !== false){
               $url = str_replace('.html?', '/p/[PAGE].html?', $url);
            }elseif(strpos($url,'?') !== false){
                $url = str_replace('?', '/p/[PAGE]?', $url);
            }elseif(strpos($url,'.html') !== false){
                $url = str_replace('.html', '/p/[PAGE].html', $url);
            }else{
               $url .= '/p/[PAGE]';
            }
        }else{
            $url = preg_replace('!/p/\d*!', '/p/[PAGE]', $_SERVER['REQUEST_URI']);
        }
        
        /* 计算分页信息 */
        $totalPages = ceil($totalRows / $listRows); //总页数
        if(!empty($totalPages) && $nowPage > $totalPages) {
            $nowPage = $totalPages;
        }
        
        /*显示多少条数据*/
        $firstRow = $listRows * ($nowPage - 1) + 1;
        $lastRow = $firstRow + $listRows < $totalRows ? $firstRow + $listRows:$totalRows;
        $data['firstRow'] = $firstRow;
        $data['lastRow'] = $lastRow;
        $data['totalRows'] = $totalRows;
        $data['totalPages'] = $totalPages;
        $data['org_url'] = $url;//原始页码
        
        //上一页
        $up_row  = $nowPage - 1;
        $up_page = $up_row > 0 ? $data['prev'] = str_replace("[PAGE]", $up_row, $url) : '';

        //下一页
        $down_row  = $nowPage + 1;
        $down_page = ($down_row <= $totalPages) ? $data['next'] = str_replace("[PAGE]", $down_row, $url) : '';

        //第一页
        $data['first'] = $nowPage == 1 ? '' : str_replace("[PAGE]", 1, $url) ;

        //最后一页
        $data['last'] =  $nowPage == $totalPages ? '' :str_replace("[PAGE]", $totalPages, $url) ;
        
        /* 中间5页 */
        if($totalPages > $rollPage)
        {
            if($nowPage <ceil($rollPage/2))
            {
                $startpage = 1;
                $endpage = $totalPages > $rollPage?$rollPage:$totalPages;
            }else{
                if($nowPage + 2 > $totalPages)
                {
                    $endpage = $totalPages;
                    $startpage = $endpage-4;
                }else{
                    $startpage = $nowPage - 2 > 0 ? $nowPage - 2 : 1;
                    $endpage = $nowPage + 2 > $totalPages ? $totalPages : $nowPage + 2;
                }
            } 
            
        }else{
            $startpage = 1;
            $endpage = $totalPages;
        }
         

        //数字连接
        for($i = $startpage;$i <= $endpage;$i++)
        {
            if($startpage == $endpage) break;
        	if($nowPage == $i)
        	{
                $data['page'][$i] = 'current';
        	}else{
        		$data['page'][$i] = str_replace("[PAGE]", $i, $url);
        	}
        	
        }
       
       return $data;
    }
}
/*
    *功能：截取字符串
    *中文的情况，长度超出指定长度，返回false
    *@param： string $string字符串
    *@param： int $length 长度
    *@param： string $code 编码
    *@return：false | string 截取后的字符串
     */
if(!function_exists('get_substr'))
{
    function get_substr($string,$length,$code='utf-8')
    {
        $string = trim($string);
        $length = intval($length);
        $org_length = mb_strlen($string);
        if (preg_match("/[\x7f-\xff]/", $string)) {//存在中文的情况
            if($org_length < $length)
            {
                return $string;
            }else{
                return false;//长度超出指定长度，返回false
            }
        }else{//没有中文的情况
            $string = mb_substr($string,0,$length,$code);
            $string = trim($string);
            return $string;
        } 

    }
}
/**
*功能：处理表中以逗号分割的字段
*@param string | array $new_string 新插入的字符
*@param string $old_string 原有的字符
*@return string 处理后的字符串
*/
if(!function_exists('str_comma'))
{
    function str_comma($new_string,$old_string)
    {
        $string = '';
        if(!is_array($new_string))
        {
            $new_string = explode(',', $new_string);
        }
        if(!empty($old_string))
        {
            $old_string = explode(',', $old_string);
            $string = array_merge($new_string,$old_string);
        }else{
            $string = $new_string;
        }
        $string = array_unique($string);
        $string = implode(',', $string);
        return $string;
    }
}