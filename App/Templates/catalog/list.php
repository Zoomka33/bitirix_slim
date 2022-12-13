<?php
use App\View\View;
echo View::renderHtml('layout.header', $header, $request);
?>
    <!--================Blog Area =================-->
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-5">
                <?php if (!empty($sections)):?>
                    <div class="sidebar-categories">
                        <div class="head">Список категорий</div>
                        <ul class="main-categories">
                            <?php foreach ($sections as $section):?>
                                <li class="main-nav-list">
                                    <a class="" href="<?=View::route('catalog.section', ['sectionCode' => $section['code']])?>"><?=$section['title']?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif;?>
                <div class="sidebar-filter mt-50">
                    <div class="top-filter-head">Product Filters</div>
                    <div class="common-filter">
                        <div class="head">Brands</div>
                        <form action="#">
                            <ul>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="apple" name="brand"><label for="apple">Apple<span>(29)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="asus" name="brand"><label for="asus">Asus<span>(29)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="gionee" name="brand"><label for="gionee">Gionee<span>(19)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="micromax" name="brand"><label for="micromax">Micromax<span>(19)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="samsung" name="brand"><label for="samsung">Samsung<span>(19)</span></label></li>
                            </ul>
                        </form>
                    </div>
                    <div class="common-filter">
                        <div class="head">Color</div>
                        <form action="#">
                            <ul>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="black" name="color"><label for="black">Black<span>(29)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="balckleather" name="color"><label for="balckleather">Black
                                        Leather<span>(29)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="blackred" name="color"><label for="blackred">Black
                                        with red<span>(19)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="gold" name="color"><label for="gold">Gold<span>(19)</span></label></li>
                                <li class="filter-list"><input class="pixel-radio" type="radio" id="spacegrey" name="color"><label for="spacegrey">Spacegrey<span>(19)</span></label></li>
                            </ul>
                        </form>
                    </div>
                    <div class="common-filter">
                        <div class="head">Price</div>
                        <div class="price-range-area">
                            <div id="price-range"></div>
                            <div class="value-wrapper d-flex">
                                <div class="price">Price:</div>
                                <span>$</span>
                                <div id="lower-value"></div>
                                <div class="to">to</div>
                                <span>$</span>
                                <div id="upper-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7">
                <!-- Start Filter Bar -->
                <div class="filter-bar d-flex flex-wrap align-items-center">
                    <div class="sorting">
                        <select>
                            <option value="/"><a href="#">По умолчанию</a></option>
                            <option value="2"><a href="#">Цена, По возрастанию</a></option>
                            <option value="3"><a href="#">Цена, По убыванию</a></option>
                        </select>
                    </div>
                    <div class="sorting mr-auto">
                        <select>
                            <option value="1">Показать: 6</option>
                            <option value="2">Показать: 12</option>
                            <option value="3">Показать: 24</option>
                        </select>
                    </div>
                    <div class="pagination">
                        <?php for($i = 1; $i <= (int)$pagination['totalSize']; $i++): ?>
                            <?php $active = $pagination['pageNumber'] == $i ? 'active' : '';?>
                            <a href="?p=<?=$i?>" class="<?=$active?>"><?=$i?></a>
                        <?php endfor; ?>
                    </div>
                </div>
                <!-- End Filter Bar -->
                <!-- Start Best Seller -->
                <section class="lattest-product-area pb-40 category-list">
                    <div class="row">
                        <?php foreach ($products as $product): ?>
                            <!-- single product -->
                            <div class="col-lg-4 col-md-6">
                            <div class="single-product">
                                <img class="img-fluid" src="<?=$product['picture']?>" alt="">
                                <div class="product-details">
                                    <h6><?=$product['title']?></h6>
                                    <div class="price">
                                        <?php if ($product['price'] > $product['discountPrice']): ?>
                                            <h6><?=$product['discountPrice'] . ' р'?></h6>
                                            <h6 class="l-through"><?=$product['price'] . ' р'?></h6>
                                        <?php else: ?>
                                            <h6><?=$product['price'] . ' р'?></h6>
                                        <?php endif; ?>
                                    </div>
                                    <div class="prd-bottom">

                                        <a href="" class="social-info">
                                            <span class="ti-bag"></span>
                                            <p class="hover-text">add to bag</p>
                                        </a>
                                        <a href="" class="social-info">
                                            <span class="lnr lnr-heart"></span>
                                            <p class="hover-text">Wishlist</p>
                                        </a>
                                        <a href="" class="social-info">
                                            <span class="lnr lnr-sync"></span>
                                            <p class="hover-text">compare</p>
                                        </a>
                                        <a href="" class="social-info">
                                            <span class="lnr lnr-move"></span>
                                            <p class="hover-text">view more</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <!-- End Best Seller -->
                <!-- Start Filter Bar -->
                <div class="filter-bar d-flex flex-wrap align-items-center">
                    <div class="sorting mr-auto">
                        <select>
                            <option value="1">Show 12</option>
                            <option value="1">Show 12</option>
                            <option value="1">Show 12</option>
                        </select>
                    </div>
                    <div class="pagination">
<!--                        <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>-->
<!--                        <a href="#" class="active">1</a>-->
<!--                        <a href="#">2</a>-->
<!--                        <a href="#">3</a>-->
<!--                        <a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>-->
<!--                        <a href="#">6</a>-->
<!--                        <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>-->
                        <?php for($i = 1; $i <= (int)$pagination['totalSize']; $i++): ?>
                        <?php $active = $pagination['pageNumber'] == $i ? 'active' : '';?>
                            <a href="?p=<?=$i?>" class="<?=$active?>"><?=$i?></a>
                        <?php endfor; ?>
                    </div>
                </div>
                <!-- End Filter Bar -->
            </div>
        </div>
    </div>
    <!--================Blog Area =================-->
<?php
echo View::renderHtml('layout.footer', $footer);
?>