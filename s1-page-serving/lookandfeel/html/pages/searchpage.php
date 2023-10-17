<?php
// prevent direct internet access to this file
!defined('CL_DIR') ? die(':-)') : '';
// so, in this app we will build a simple search functionality right in the search page
// the content is generated but this page still exists as a static file
function getFragment($content, $keyword) {
    return '... '.str_replace($keyword, "<b>$keyword</b>", strip_tags($content));
}

function search($query) {
    //
    $query = mb_strtolower($query);
    $query = str_replace(',',' ',$query);
    $keywords = explode(' ', $query);
    // path to our pages
    $path = BASE_DIR . '/lookandfeel/html/pages/';
    // list of pages we will search
    $pages = ['about.php', 'contactpage.php'];
    $results = [];$distribution = [];
    foreach($pages as $page) {
        $content = file_get_contents($path.$page);
        foreach($keywords as $keyword) {
            $distribution[$page][$keyword] = substr_count($content, $keyword);
            if ($distribution[$page][$keyword] > 0) {
                $results[] = ['page' => $page, 'fragment' => getFragment($content, $keyword)];
            }
        }
    }
    return count($results) > 0 ? $results : [['page'=>'','fragment'=>'Nothing found']];
}
$query = $this->clrequest->post('keywords') ?? null;
if (isset($query)) {
    $results = search($query);
}
?>
<div class="bg-body-tertiary p-5 m-5 rounded">
    <div class="row">
        <div class="col-12 center"><h3><?php echo $title ?? 'Your search results';?></h3></div>
    </div>
    <div class="row ">
        <div class="col-12">
            <?php if (isset($results) && count($results) > 0) {
                foreach ($results as $result) {?>
            <div class="row">
                <div class="col-md-6">
                    <?php echo $result['page'];?>
                </div>
                <div class="col-md-6">
                    <?php echo $result['fragment'];?>
                </div>
            </div>
               <?php }
                ?>

            <?php }?>
        </div>
    </div>
</div>
