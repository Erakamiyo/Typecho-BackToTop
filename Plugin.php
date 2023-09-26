<?php
/**
 * 东方返回顶部样式。<br>开源项目：<a href="https://github.com/xiamuguizhi/Typecho-BackToTop" title="Github" target="_black">xiamuguizhi/Typecho-BackToTop</a>.
 *
 * @package BackToTop
 * @author 夏目贵志
 * @version 1.0
 * @link https://xiamuyourenzhang.cn/
 */

class BackToTop_Plugin implements Typecho_Plugin_Interface {
    /**
     * 激活插件方法，如果激活失败，直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        Typecho_Plugin::factory('Widget_Archive')->header = array('BackToTop_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('BackToTop_Plugin', 'footer');
    }

   /**
     * 禁用插件方法，如果禁用失败，直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate() {

    }
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
     
    /**
     * 选项样式
     * 
     * Typecho_Widget_Helper_Form_Element_Checkbox() 方框
     * Typecho_Widget_Helper_Form_Element_Radio() 圆点
     */
    
    public static function config(Typecho_Widget_Helper_Form $form) {
		$form->addInput(new Typecho_Widget_Helper_Form_Element_Checkbox('jsSettings', NULL, NULL, _t('<h2> Js 设置 </h2>'), _t('<strong>在这里自定义你的Js设置。</strong> <br /><br /><div class="divider"></div>')));
        
        $jquery = new Typecho_Widget_Helper_Form_Element_Radio('jquery', array('1' => _t('是'), '0' => _t('否')), '0', _t('是否启用插件内jQuery？'), _t('本插件需要jQuery。如果主题模板已经引用加载jQuery，则应选否，避免重复加载。<strong>默认选否。</strong>'));
        $form->addInput($jquery);
        $jQueryLinkCustom = new Typecho_Widget_Helper_Form_Element_Text('jQueryLinkCustom', NULL, NULL, _t('自定义引用jQuery地址'), _t('<strong>此选项仅在启用插件内jQuery功能后有效。可为空，默认使用插件自带jQuery (3.7.1.min.js)。</strong><br>可替换为其他位置文件或CDN文件加速。'));
        $form->addInput($jQueryLinkCustom);
    }
    

   /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {

    }

    
    /**
     * 页头输出相关代码
     *
     * @access public
     * @param unknown header
     * @return unknown
     */
    public static function header() {
        $Path = Helper::options()->pluginUrl . '/BackToTop/';
        echo '<link rel="stylesheet" type="text/css" href="' . $Path . 'css/BackToTop.css" />';
    }


    /**
     * 页脚输出相关代码
     *
     * @access public
     * @param unknown footer
     * @return unknown
     */
    public static function footer() {
		 srand( microtime() * 1000000 );
		 $num = rand( 1, 3 );
		  
		 switch( $num )
		 {
		 case 1: $image_file = "flandre.png";
			 break;
		 case 2: $image_file = "marisa.png";
			 break;
		 case 3: $image_file = "reimu.png";
			 break;
		 }		
        $Options = Helper::options()->plugin('BackToTop');
        $Path = Helper::options()->pluginUrl . '/BackToTop/';
        $jQueryLink = "' . $Path . 'js/ajax_libs_jquery_3.7.1.min.js";
        echo '<img id="BackToTop" src="' . $Path . 'images/'.$image_file.'" title="返回顶部~">';
        
        if (isset($Options->jquery) && $Options->jquery == '1') {
            if (isset($Options->jQueryLinkCustom) && $Options->jQueryLinkCustom !== NULL) {
				echo '<script type="text/javascript" src="' . $jQueryLinkCustom . '"></script>';
			} else {
				echo '<script type="text/javascript" src="' . $jQueryLink . '"></script>';
			}
        }
        /**
         * 原版
         * 
         * if (!$Options->jquery || !in_array('jquery', $Options->jquery)) {
		 *     echo '<script type="text/javascript" src="' . $Path . 'js/ajax_libs_jquery_3.7.1.min.js"></script>';
         * }
         */
         
        echo '<script type="text/javascript">
			$(function(){
				$("#BackToTop").click(function() {
					$("html, body").animate({scrollTop:0}, 500);
				}); 
			})
		</script>';
    }
    
}


