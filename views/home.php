<div class="container mainContainer" style="padding: 20px;">
<div class="row">
  <div class="col-sm-8">
    <h2>Recent tweets</h2>
    <?php displayTweets('public');?>
  </div>
  <div class="col-sm-4">
      <?php displaySearch(); ?>
      <hr>
      <?php displayTweetBox(); ?>

  </div>
</div>

</div>