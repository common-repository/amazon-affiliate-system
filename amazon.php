<?php
/*
  Plugin Name: Amazon Affiliate System
  Plugin URI: http://www.winwinhost.com/page.php/opensource/AmazonAffiliateSystem/
  Description: Connects with AWS and gets product information.
  Version: 1.3
  Author: WinWinHost
  Author URI: http://www.winwinhost.com/
 */

if (key_exists("content", $_GET) && $_GET['content'] == "css") {
    css_content();
}
if (key_exists("hide_donate", $_GET) && $_GET['hide_donate'] == "1") {
    update_option('amazon_show_donate', '0');
}

function amazon_install() {
    global $wpdb;

    add_option("key_id");
    add_option("secret_key");
    add_option("assoc_tag");
    add_option('amazon_shop_title', 'My Shop');
    add_option('amazon_keywords', 'php');
    add_option('amazon_section', 'Books');
    add_option('amazon_locale', 'US');
    add_option('amazon_show_sidebar', '1');
    add_option('amazon_itemattributes', 'a:0:{}');
    add_option('amazon_th_width', '160');
    add_option('amazon_th_height', '160');
    add_option('amazon_pagination_width', '460px');
    add_option('amazon_table_width', '460px');
    add_option('amazon_table_border', '1px solid #ccc');
    add_option('amazon_pagination_divstyle', "background: #4283b9;\ncolor: #fff;\npadding: 0 5px;\nclear: both;\nwidth: 460px;\nheight: 19px");
    add_option('amazon_pagination_lnkcolor', '#fff');
    add_option('amazon_pagination_lnkhovercolor', '#fff');
    add_option('amazon_pagination_lnkhoverbgcolor', '#68A0F3');
    add_option('amazon_table_cols', '1');
    add_option('amazon_list_attribute1');
    add_option('amazon_list_attribute2');
    add_option('amazon_list_attribute3');
    add_option('amazon_list_attribute4');
    add_option('amazon_list_div_style', "float: left;\npadding: 0 0 20px 45px;\nwidth:460px");
    add_option('amazon_detail_div_style', "float: left;\npadding: 0 0 20px 45px;\nwidth:460px");
    add_option('amazon_show_donate', '1');

    //copy(dirname(__FILE__)."/amazon_template.php", get_template_directory()."/amazon_template.php");

    $wpdb->query("INSERT INTO `wp_posts` (`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (1, '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', '[shop]', 'Shop', '', 'publish', 'open', 'open', '', 'shop', '', '', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', '', 0, '', 0, 'page', '', 0)");

    $page_id = mysql_insert_id();

    add_option('amazon_page_id', $page_id);

    //$wpdb->query("INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) VALUES (".$page_id.", '_wp_page_template', 'amazon_template.php')");
}

function amazon_uninstall() {
    global $wpdb;

    $wpdb->query("DELETE FROM wp_posts WHERE ID = " . get_option('amazon_page_id'));

    delete_option("key_id");
    delete_option("secret_key");
    delete_option("assoc_tag");
    delete_option('amazon_shop_title');
    delete_option('amazon_keywords');
    delete_option('amazon_section');
    delete_option('amazon_locale');
    delete_option('amazon_show_sidebar');
    delete_option('amazon_itemattributes');
    delete_option('amazon_th_width');
    delete_option('amazon_th_height');
    delete_option('amazon_pagination_width');
    delete_option('amazon_table_width');
    delete_option('amazon_table_border');
    delete_option('amazon_pagination_divstyle');
    delete_option('amazon_pagination_lnkcolor');
    delete_option('amazon_pagination_lnkhovercolor');
    delete_option('amazon_pagination_lnkhoverbgcolor');
    delete_option('amazon_table_cols');
    delete_option('amazon_list_attribute1');
    delete_option('amazon_list_attribute2');
    delete_option('amazon_list_attribute3');
    delete_option('amazon_list_attribute4');
    delete_option('amazon_list_div_style');
    delete_option('amazon_detail_div_style');
    delete_option('amazon_show_donate');
    delete_option('amazon_page_id');

    //unlink(get_template_directory()."/amazon_template.php");
}

function amazon_admin_menu() {
    add_options_page('Amazon Affiliate System', 'Amazon Affiliate System', 'manage_options', basename(__FILE__), 'amazon_options');
}

function amazon_options() {

    $ItemAttributes = array('Actor', 'Address1', 'Address2', 'Address3', 'AmazonMaximumAge', 'AmazonMinimumAge', 'Amount', 'ApertureModes', 'Artist', 'ASIN', 'AspectRatio', 'AudienceRating', 'AudioFormat', 'Author', 'BackFinding', 'BandMaterialType', 'Batteries', 'BatteriesIncluded', 'BatteryDescription', 'BatteryType', 'BezelMaterialType', 'Binding', 'Brand', 'CalendarType', 'CameraManualFeatures', 'CaseDiameter', 'CaseMaterialType', 'CaseThickness', 'CaseType', 'CDRWDescription', 'ChainType', 'City', 'ClaspType', 'ClothingSize', 'Color', 'Compatibility', 'CPUManufacturer', 'CPUSpeed', 'CPUType', 'Creator', 'CurrencyCode', 'Day', 'DelayBetweenShots', 'Department', 'DetailPageURL', 'DeweyDecimalNumber', 'DialColor', 'DialWindowMaterialType', 'DigitalZoom', 'Director', 'DisplaySize', 'DVDLayers', 'DVDRWDescription', 'DVDSides', 'EAN', 'Edition', 'EpisodeSequence', 'ESRBAgeRating', 'ExternalDisplaySupportDescription', 'FabricType', 'FaxNumber', 'Feature', 'FirstIssueLeadTime', 'FlavorName', 'FloppyDiskDriveDescription', 'Format', 'FormattedPrice', 'GemType', 'GemTypeSetElement', 'Genre', 'GolfClubFlex', 'GolfClubLoft', 'GraphicsCardInterface', 'GraphicsDescription', 'GraphicsMemorySize', 'HardDiskCount', 'HardDiskSize', 'HasAutoFocus', 'HasBurstMode', 'HasInCameraEditing', 'HasRedEyeReduction', 'HasSelfTimer', 'HasTripodMount', 'HasVideoOut', 'HasViewfinder', 'Height', 'Hours', 'HoursOfOperation', 'IncludedSoftware', 'IncludesMp3Player', 'Ingredients', 'IngredientsSetElement', 'IsAutographed', 'IsEligibleForTradeIn', 'ISBN', 'IngredientsSetElement', 'IsEmailNotifyAvailable', 'IsFragile', 'IsLabCreated', 'IsMemorabilia', 'ISOEquivalent', 'IssuesPerYear', 'KeyboardDescription', 'Keywords', 'Label', 'LegalDisclaimer', 'Length', 'LongSynopsis', 'LineVoltage', 'MacroFocusRange', 'MagazineType', 'Manufacturer', 'ManufacturerLaborWarrantyDescription', 'ManufacturerMaximumAge', 'MaterialTypeSetElement', 'ManufacturerMinimumAge', 'ManufacturerPartsWarrantyDescription', 'MaterialType', 'MaximumAperture', 'MaximumColorDepth', 'MaximumFocalLength', 'MaximumHighResolutionImages', 'MaximumHorizontalResolution', 'MaximumLowResolutionImages', 'MaximumResolution', 'MaximumShutterSpeed', 'MaximumVerticalResolution', 'MaximumWeightRecommendation', 'MemorySlotsAvailable', 'Message', 'MetalStamp', 'MetalType', 'MiniMovieDescription', 'MinimumFocalLength', 'MinimumShutterSpeed', 'Model', 'ModemDescription', 'MonitorSize', 'MonitorViewableDiagonalSize', 'MouseDescription', 'MPN', 'Name', 'NativeResolution', 'Neighborhood', 'NetworkInterfaceDescription', 'NotebookDisplayTechnology', 'NotebookPointingDeviceDescription', 'NumberOfDiscs', 'NumberOfIssues', 'NumberOfItems', 'NumberOfPages', 'NumberOfPearls', 'NumberOfRapidFireShots', 'NumberOfStones', 'NumberOfTracks', 'OpticalZoom', 'OriginalAirDate', 'OriginalReleaseDate', 'PearlLustre', 'PearlMinimumColor', 'PearlShape', 'PearlStringingMethod', 'PearlSurfaceBlemishes', 'PearlType', 'PearlUniformity', 'PhoneNumber', 'PhotoFlashType', 'PictureFormat', 'Platform', 'PostalCode', 'PriceRating', 'ProcessorCount', 'ProductGroup', 'PublicationDate', 'Publisher', 'ReadingLevel', 'RegionCode', 'ReleaseDate', 'RemovableMemory', 'ResolutionModes', 'RingSize', 'Role', 'RunningTime', 'SeasonSequence', 'SecondaryCacheSize', 'SettingType', 'ShortSynopsis', 'Size', 'SizePerPearl', 'SKU', 'SoundCardDescription', 'SpeakerDescription', 'SpecialFeatures', 'StartYear', 'State', 'StoneClarity', 'StoneColor', 'StoneCut', 'StoneShape', 'StoneWeight', 'Studio', 'SubscriptionLength', 'SupportedImageType', 'SystemBusSpeed', 'SystemMemorySize', 'SystemMemorySizeMax', 'SystemMemoryType', 'TheatricalReleaseDate', 'Title', 'TotalDiamondWeight', 'TotalExternalBaysFree', 'TotalFirewirePorts', 'TotalGemWeight', 'TotalInternalBaysFree', 'TotalMetalWeight', 'TotalNTSCPALPorts', 'TotalPages', 'TotalParallelPorts', 'TotalPCCardSlots', 'TotalPCISlotsFree', 'TotalResults', 'TotalSerialPorts', 'TotalSVideoOutPorts', 'TotalUSBPorts', 'TotalUSB2Ports', 'TotalVGAOutPorts', 'TradeInValue', 'Type', 'Unit', 'UPC', 'VariationDenomination', 'VariationDescription', 'Warranty', 'WatchMovementType', 'WaterResistanceDepth', 'Weight', 'Width');

    global $wpdb;
    $errors = array();
    if (key_exists('key_id', $_POST)) {
        foreach ($_POST as $key => $value) {
            if (!is_array($value)) {
                update_option($key, $value);
                if (strlen($value) == 0) {
                    $errors[] = $key;
                }
            } else {
                update_option($key, serialize($value));
            }
        }
        if (!key_exists('amazon_itemattributes', $_POST)) {
            update_option('amazon_itemattributes', serialize(array()));
        }
    }

    $td_title = "text-align:center;font-weight:bold;background-color:#888;color:#fff;padding:3px";
    ?>
    <div class="wrap">
        <h2>Amazon integration</h2>
        <?php if (get_option('amazon_show_donate') == '1') { ?>
            <div>
                <div style="float:left">
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_s-xclick" />
                        <input type="hidden" name="hosted_button_id" value="EP68S8BRUTNE6" />
                        <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" />
                        <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
                    </form>
                </div>
                <a href="<?php echo $_SERVER['REQUEST_URI'] . "&hide_donate=1"; ?>">hide</a>
                <br clear="both" />
            </div>
        <?php } ?>
        <br />
        <div style="float: left;width:800px">
            <form action = "" method="post">
                <table class="form-table">
                    <tr><td colspan="2" style="<?php echo $td_title; ?>">Access information</td></tr>
                    <tr><td colspan="2" <?php echo in_array('key_id', $errors) ? ' style="color:red"' : ''; ?>>Access Key ID:</td></tr>
                    <tr><td colspan="2"><input type="text" name="key_id" value="<?php echo get_option('key_id'); ?>" style="width:100%" /></td></tr>
                    <tr><td colspan="2" <?php echo in_array('secret_key', $errors) ? ' style="color:red"' : '' ?>>Secret Access Key</td></tr>
                    <tr><td colspan="2"><input type="text" name="secret_key" value="<?php echo get_option('secret_key'); ?>" style="width:100%" /></td></tr>
                    <tr><td colspan="2" <?php echo in_array('assoc_tag', $errors) ? ' style="color:red"' : '' ?>>Associates Tag</td></tr>
                    <tr><td colspan="2"><input type="text" name="assoc_tag" value="<?php echo get_option('assoc_tag'); ?>" style="width:100%" /></td></tr>
                    <tr><td colspan="2" style="<?php echo $td_title; ?>">General shop information</td></tr>
                    <tr><td colspan="2">Shop title (leave blank if you don't want any to be shown)</td></tr>
                    <tr><td colspan="2"><input type="text" name="amazon_shop_title" value="<?php echo get_option('amazon_shop_title'); ?>" style="width:100%" /></td></tr>
                    <tr><td width="8%">Products section</td>
                        <td>
                            <select name="amazon_section">
                                <option value="All" <?php echo get_option('amazon_section') == "All" ? 'selected="selected"' : ''; ?>>All</option>
                                <option value="Apparel" <?php echo get_option('amazon_section') == "Apparel" ? 'selected="selected"' : ''; ?>>Apparel</option>		 	 	 
                                <option value="Baby" <?php echo get_option('amazon_section') == "Baby" ? 'selected="selected"' : ''; ?>>Baby</option>		 	 	 
                                <option value="Beauty" <?php echo get_option('amazon_section') == "Beauty" ? 'selected="selected"' : ''; ?>>Beauty</option>		 	 	 
                                <option value="Blended" <?php echo get_option('amazon_section') == "Blended" ? 'selected="selected"' : ''; ?>>Blended</option>				
                                <option value="Books" <?php echo get_option('amazon_section') == "Books" ? 'selected="selected"' : ''; ?>>Books</option>				
                                <option value="Classical" <?php echo get_option('amazon_section') == "Classical" ? 'selected="selected"' : ''; ?>>Classical</option>				
                                <option value="DigitalMusic" <?php echo get_option('amazon_section') == "DigitalMusic" ? 'selected="selected"' : ''; ?>>Digital Music</option>		 	 	 
                                <option value="DVD" <?php echo get_option('amazon_section') == "DVD" ? 'selected="selected"' : ''; ?>>DVD</option>				
                                <option value="Electronics" <?php echo get_option('amazon_section') == "Electronics" ? 'selected="selected"' : ''; ?>>Electronics</option>				
                                <option value="ForeignBooks" <?php echo get_option('amazon_section') == "ForeignBooks" ? 'selected="selected"' : ''; ?>>Foreign Books</option>	 	 		
                                <option value="GourmetFood" <?php echo get_option('amazon_section') == "GourmetFood" ? 'selected="selected"' : ''; ?>>Gourmet Food</option>		 	 	 
                                <option value="HealthPersonalCare" <?php echo get_option('amazon_section') == "HealthPersonalCare" ? 'selected="selected"' : ''; ?>>Health, Personal Care</option>				 
                                <option value="HomeGarden" <?php echo get_option('amazon_section') == "HomeGarden" ? 'selected="selected"' : ''; ?>>Home, Garden</option>	 			 
                                <option value="Jewelry" <?php echo get_option('amazon_section') == "Jewelry" ? 'selected="selected"' : ''; ?>>Jewelry</option>		 	 	 
                                <option value="Kitchen" <?php echo get_option('amazon_section') == "Kitchen" ? 'selected="selected"' : ''; ?>>Kitchen</option>				
                                <option value="Magazines" <?php echo get_option('amazon_section') == "Magazines" ? 'selected="selected"' : ''; ?>>Magazines</option>		 		 
                                <option value="Merchants" <?php echo get_option('amazon_section') == "Merchants" ? 'selected="selected"' : ''; ?>>Merchants</option>		 	 	 
                                <option value="Miscellaneous" <?php echo get_option('amazon_section') == "Miscellaneous" ? 'selected="selected"' : ''; ?>>Miscellaneous</option>		 	 	 
                                <option value="Music" <?php echo get_option('amazon_section') == "Music" ? 'selected="selected"' : ''; ?>>Music</option>				
                                <option value="MusicalInstruments" <?php echo get_option('amazon_section') == "MusicalInstruments" ? 'selected="selected"' : ''; ?>>Musical Instruments</option>		 	 	 
                                <option value="MusicTracks" <?php echo get_option('amazon_section') == "MusicTracks" ? 'selected="selected"' : ''; ?>>Music Tracks</option>				
                                <option value="OfficeProducts" <?php echo get_option('amazon_section') == "OfficeProducts" ? 'selected="selected"' : ''; ?>>OfficeProducts</option>		 	 	 
                                <option value="OutdoorLiving" <?php echo get_option('amazon_section') == "OutdoorLiving" ? 'selected="selected"' : ''; ?>>Outdoor Living</option>				 
                                <option value="PCHardware" <?php echo get_option('amazon_section') == "PCHardware" ? 'selected="selected"' : ''; ?>>PC Hardware</option>		 		 
                                <option value="Photo" <?php echo get_option('amazon_section') == "Photo" ? 'selected="selected"' : ''; ?>>Photo</option>		 		 
                                <option value="Restaurants" <?php echo get_option('amazon_section') == "Restaurants" ? 'selected="selected"' : ''; ?>>Restaurants</option>		 	 	 
                                <option value="Software" <?php echo get_option('amazon_section') == "Software" ? 'selected="selected"' : ''; ?>>Software</option>				
                                <option value="SoftwareVideoGames" <?php echo get_option('amazon_section') == "SoftwareVideoGames" ? 'selected="selected"' : ''; ?>>Software, Video Games</option>	 			 
                                <option value="SportingGoods" <?php echo get_option('amazon_section') == "SportingGoods" ? 'selected="selected"' : ''; ?>>Sporting Goods</option>		 	 	 
                                <option value="Tools" <?php echo get_option('amazon_section') == "Tools" ? 'selected="selected"' : ''; ?>>Tools</option>		 		 
                                <option value="Toys" <?php echo get_option('amazon_section') == "Toys" ? 'selected="selected"' : ''; ?>>Toys</option>			 	
                                <option value="VHS" <?php echo get_option('amazon_section') == "VHS" ? 'selected="selected"' : ''; ?>>VHS</option>				
                                <option value="Video" <?php echo get_option('amazon_section') == "Video" ? 'selected="selected"' : ''; ?>>Video</option>				
                                <option value="VideoGames" <?php echo get_option('amazon_section') == "VideoGames" ? 'selected="selected"' : ''; ?>>Video Games</option>				
                                <option value="Wireless" <?php echo get_option('amazon_section') == "Wireless" ? 'selected="selected"' : ''; ?>>Wireless</option>		 	 	 
                                <option value="WirelessAccessories" <?php echo get_option('amazon_section') == "WirelessAccessories" ? 'selected="selected"' : ''; ?>>Wireless Accessories</option>
                            </select>
                        </td>
                    </tr>
                    <tr><td>Locale</td>
                        <td>
                            <select name="amazon_locale">
                                <option value="US" <?php echo get_option('amazon_locale') == "US" ? 'selected="selected"' : ''; ?>>US</option>
                                <option value="UK" <?php echo get_option('amazon_locale') == "UK" ? 'selected="selected"' : ''; ?>>UK</option>
                                <option value="DE" <?php echo get_option('amazon_locale') == "DE" ? 'selected="selected"' : ''; ?>>DE</option>
                                <option value="JP" <?php echo get_option('amazon_locale') == "JP" ? 'selected="selected"' : ''; ?>>JP</option>
                            </select>
                        </td>
                    </tr>
                    <tr><td colspan="2">Keywords</td></tr>
                    <tr><td colspan="2"><input type="text" name="amazon_keywords" value="<?php echo get_option('amazon_keywords'); ?>" style="width:100%" /></td></tr>
                    <tr><td>Show sidebar in shop</td><td><select name="amazon_show_sidebar"><option value="1"<?php echo get_option('amazon_show_sidebar') == "1" ? ' selected="selected"' : ''; ?>>Yes</option><option value="0"<?php echo get_option('amazon_show_sidebar') == "0" ? ' selected="selected"' : ''; ?>>No</option></select></td></tr>
                    <tr><td>List container DIV style:</td><td><textarea rows="5" style="width:100%" name="amazon_list_div_style"><?php echo get_option('amazon_list_div_style'); ?></textarea></td></tr>
                    <tr><td colspan="2" style="<?php echo $td_title ?>">List page</td></tr>
                    <tr><td>Thumbnail maximum size</td><td><input type="text" size="2" name="amazon_th_width" value="<?php echo get_option('amazon_th_width'); ?>" /> X <input type="text" size="2" name="amazon_th_height" value="<?php echo get_option('amazon_th_height'); ?>" /> pixels</td></tr>
                    <tr><td>Pagination DIV style:</td><td><textarea style="width:100%" rows="5" name="amazon_pagination_divstyle"><?php echo get_option('amazon_pagination_divstyle'); ?></textarea></td></tr>
                    <tr><td>Pagination bar link text color:</td><td><input type="text" name="amazon_pagination_lnkcolor" value="<?php echo get_option('amazon_pagination_lnkcolor'); ?>" /></td></tr>
                    <tr><td>Pagination bar link hover text color:</td><td><input type="text" name="amazon_pagination_lnkhovercolor" value="<?php echo get_option('amazon_pagination_lnkhovercolor'); ?>" /></td></tr>
                    <tr><td>Pagination bar link hover background color:</td><td><input type="text" name="amazon_pagination_lnkhoverbgcolor" value="<?php echo get_option('amazon_pagination_lnkhoverbgcolor'); ?>" /></td></tr>
                    <tr><td>Products table width:</td><td><input type="text" name="amazon_table_width" value="<?php echo get_option('amazon_table_width'); ?>" /></td></tr>
                    <tr><td>Products table number of columns:</td><td><input type="text" name="amazon_table_cols" value="<?php echo get_option('amazon_table_cols'); ?>" /></td></tr>
                    <tr><td>Products table border:</td><td><input type="text" name="amazon_table_border" value="<?php echo get_option('amazon_table_border'); ?>" /></td></tr>
                    <tr><td>Products table style:</td><td><textarea style="width:100%" rows="5" name="amazon_table_style"><?php echo get_option('amazon_table_style'); ?></textarea></td></tr>
                    <tr><td colspan="2">Additional attributes (attributes always shown: Title, Price, Rating):</td></tr>
                    <tr><td colspan="2">
                            <table width="100%">
                                <tr>
                                    <td width="50%">1. 
                                        <select name="amazon_list_attribute1">
                                            <option value="">None</option>
                                            <?php foreach ($ItemAttributes as $key => $Attribute) { ?>
                                                <option value="<?php echo $Attribute; ?>"<?php echo get_option('amazon_list_attribute1') == $Attribute ? ' selected="selected"' : ''; ?>><?php echo $Attribute; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>3. 
                                        <select name="amazon_list_attribute3">
                                            <option value="">None</option>
                                            <?php foreach ($ItemAttributes as $key => $Attribute) { ?>
                                                <option value="<?php echo $Attribute ?>"<?php echo get_option('amazon_list_attribute3') == $Attribute ? ' selected="selected"' : ''; ?>><?php echo $Attribute; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">2. 
                                        <select name="amazon_list_attribute2">
                                            <option value="">None</option>
                                            <?php foreach ($ItemAttributes as $key => $Attribute) { ?>
                                                <option value="<?php echo $Attribute ?>"<?php echo get_option('amazon_list_attribute2') == $Attribute ? ' selected="selected"' : ''; ?>><?php echo $Attribute; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>4. 
                                        <select name="amazon_list_attribute4">
                                            <option value="">None</option>
                                            <?php foreach ($ItemAttributes as $key => $Attribute) { ?>
                                                <option value="<?php echo $Attribute ?>"<?php echo get_option('amazon_list_attribute4') == $Attribute ? ' selected="selected"' : ''; ?>><?php echo $Attribute; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td colspan="2" style="<?php echo $td_title; ?>">Detail page</td></tr>
                    <tr><td>Detail page container DIV style:</td><td><textarea name="amazon_detail_div_style" style="width:100%" rows="5"><?php echo get_option('amazon_detail_div_style'); ?></textarea></td></tr>
                    <tr>
                        <td colspan="2">Attributes shown</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            $SelectedAttributes = array();
                            $SelectedAttributes = unserialize(get_option('amazon_itemattributes'));
                            ?>
                            <table width="100%">
                                <?php
                                $i = 0;
                                foreach ($ItemAttributes as $key => $Attribute) {
                                    if (!in_array($Attribute, array('Title', 'Price'))) {
                                        if ($i % 3 == 0) {
                                            echo '<tr>';
                                        }
                                        $selected = in_array($Attribute, $SelectedAttributes) ? 'checked="checked"' : '';
                                        echo '<td width="5%"><input type="checkbox" name="amazon_itemattributes[]" value="' . $Attribute . '" ' . $selected . ' /></td><td width="28%">' . $Attribute . '</td>';
                                        if (($i + 1) % 3 == 0) {
                                            echo '</tr>';
                                        }
                                        $i++;
                                    }
                                }
                                ?>
                            </table>		
                        </td>
                    </tr>
                    <tr><td colspan="2"><input type="submit" value="save" style="width:100%" /></td></tr>
                </table>
            </form>
        </div>
    </div>
    <?php
}

function css_link() {
    ?>
    <style type="text/css">
        div.d_pag { <?php echo get_option('amazon_pagination_divstyle'); ?>;width:98%}
        div.d_pag em { float: left; font-style: normal; padding: 2px; display: block; }
        /* l2 */
        div.d_pag a:link, div.d_pag a:visited { color: <?php echo get_option('amazon_pagination_lnkcolor'); ?>; padding: 2px 5px; display: block; float: left; text-decoration: none}
        div.d_pag a:active, div.d_pag a:hover { color: <?php echo get_option('amazon_pagination_lnkhovercolor'); ?>;background: <?php echo get_option('amazon_pagination_lnkhoverbgcolor'); ?>;   }

        div.d_pag a.act:link, div.d_pag a.act:visited { background: #E1F3D7; color: #4283b9;  text-decoration: none}
        div.d_pag a.act:active, div.d_pag a.act:hover { background: #fff;   }
        div.d_pag td,div.d_pag th{padding:0}

        div.d_list{<?php echo get_option('amazon_list_div_style'); ?>}
        div.d_detail{<?php echo get_option('amazon_detail_div_style'); ?>}

        table.t_shop {border-left:<?php echo get_option('amazon_table_border'); ?>;border-top:<?php echo get_option('amazon_table_border'); ?>; width:<?php echo get_option('amazon_table_width'); ?>;<?php echo get_option('amazon_table_style'); ?>}
        table.t_shop td {border-right:<?php echo get_option('amazon_table_border'); ?>;border-bottom:<?php echo get_option('amazon_table_border'); ?>;padding:5px}

        p.p_powered{text-align:center;border-top:1px solid #ccc;margin-top:10px}
    </style>
    <?php
}

function get_amazon_shop() {
    include dirname(__FILE__) . "/amazon_template.php";
}

register_activation_hook(__FILE__, 'amazon_install');
register_deactivation_hook(__FILE__, 'amazon_uninstall');
add_action('admin_menu', 'amazon_admin_menu');
add_shortcode('shop', 'get_amazon_shop');
add_action('wp_head', 'css_link');
?>
