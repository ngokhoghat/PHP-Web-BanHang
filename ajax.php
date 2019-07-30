<?php
include 'config/funtion.php';

$id = $_GET['id'];
$result = execute("SELECT * FROM product WHERE id = $id")->fetch_assoc();
?>
<!-- Modal -->
<div class="modal fade" id="productModal<?php echo $id ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="modal-tab">
                            <div class="product-details-large tab-content">
                                <div class="tab-pane active" id="image-1">
                                    <img src="admin/public/image/product/<?php echo $result['anh_bia'] ?>" alt="" style="width: 100%" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-12">
                        <div class="modal-pro-content">
                            <h3 style="font-size: 20px"><?php echo $result['name'] ?></h3>
                            <div class="product-price">
                                <ul>
                                    <?php if ($result['sale_price'] > 0) { ?>
                                        <li class="price"><?php echo number_format($result['sale_price']) . ' đ'; ?></li>
                                        <li class="price old-price"><?php echo number_format($result['price']) . ' đ'; ?></li>
                                    <?php } else { ?>
                                        <li class="price"><?php echo number_format($result['price']) . ' đ'; ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="product-addto-links-text">
                                <p><?php echo $result["mota"]; ?></p>
                            </div>
                            <div class="product-reviews-summary">
                                <div class="rating-summary">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                                <div class="reviews-actions">
                                    <a href="#">3 Reviews</a>
                                    <a href="#" class="view">Add Your Review</a>
                                </div>
                            </div>
                            <div class="product-add-form">
                                <form action="xuli-cart.php" id="q-addtocart">
                                    <div class="quality-button">
                                        <input class="qty" type="hidden" value="<?php echo $result["id"]; ?>" name="id">
                                        <input class="qty" type="hidden" value="add" name="action">
                                        <input class="qty" type="number" value="1" name="quantity">
                                    </div>
                                    <a href="javascript:{}" onclick="document.getElementById('q-addtocart').submit();">Add to cart</a>
                                </form>
                            </div>
                            <div class="product-social-links">
                                <div class="product-addto-links">
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                    <a href="#"><i class="fa fa-pie-chart"></i></a>
                                    <a href="#"><i class="fa fa-envelope-o"></i></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->