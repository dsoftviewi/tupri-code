<?PHP include "header.php"; ?>

        <div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">Hotel Detailed</h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="#">HOME</a></li>
                    <li class="active">Hotel Detailed</li>
                </ul>
            </div>
        </div>
        <section id="content">
            <div class="container">
                <div class="row">
                    <div id="main" class="col-md-9">
                        <div class="tab-container style1" id="hotel-main-content">
                            <ul class="tabs">
                                <li class="active"><a data-toggle="tab" href="#photos-tab">photos</a></li>
                                <li><a data-toggle="tab" href="#map-tab">map</a></li>
                                <li><a data-toggle="tab" href="#steet-view-tab">street view</a></li>
                                <li><a data-toggle="tab" href="#calendar-tab">calendar</a></li>
                                <li class="pull-right"><a class="button btn-small yellow-bg white-color" href="#">TRAVEL GUIDE</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="photos-tab" class="tab-pane fade in active">
                                    <div class="photo-gallery style1" data-animation="slide" data-sync="#photos-tab .image-carousel">
                                        <ul class="slides">
                                            <li><img src="images/shortcodes/gallery-popup/1.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/2.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/3.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/4.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/5.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/6.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/7.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/8.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/9.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/10.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/11.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/12.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/13.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                        </ul>
                                    </div>
                                    <div class="image-carousel style1" data-animation="slide" data-item-width="70" data-item-margin="10" data-sync="#photos-tab .photo-gallery">
                                        <ul class="slides">
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/1.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/2.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/3.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/4.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/5.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/6.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/7.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/8.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/9.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/10.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/11.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/12.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                            <li><img src="images/shortcodes/gallery-popup/thumbnail/13.jpg" alt="tour operators in trichy" title="travel agencies in trichy" /></li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="map-tab" class="tab-pane fade">
                                    
                                </div>
                                <div id="steet-view-tab" class="tab-pane fade" style="height: 500px;">
                                    
                                </div>
                                <div id="calendar-tab" class="tab-pane fade">
                                    <label>SELECT MONTH</label>
                                    <div class="col-sm-6 col-md-4 no-float no-padding">
                                        <div class="selector">
                                            <select class="full-width" id="select-month">
                                                <option value="2014-6">June 2014</option>
                                                <option value="2014-7">July 2014</option>
                                                <option value="2014-8">August 2014</option>
                                                <option value="2014-9">September 2014</option>
                                                <option value="2014-10">October 2014</option>
                                                <option value="2014-11">November 2014</option>
                                                <option value="2014-12">December 2014</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="calendar"></div>
                                            <div class="calendar-legend">
                                                <label class="available">available</label>
                                                <label class="unavailable">unavailable</label>
                                                <label class="past">past</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="description">
                                                The calendar is updated every five minutes and is only an approximation of availability.
<br /><br />
Some hosts set custom pricing for certain days on their calendar, like weekends or holidays. The rates listed are per day and do not include any cleaning fee or rates for extra people the host may have for this listing. Please refer to the listing's Description tab for more details.
<br /><br />
We suggest that you contact the host to confirm availability and rates before submitting a reservation request.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="hotel-features" class="tab-container">
                            <ul class="tabs">
                                <li class="active"><a href="#hotel-description" data-toggle="tab">Description</a></li>
                                <li><a href="#hotel-availability" data-toggle="tab">Availability</a></li>
                                <li><a href="#hotel-amenities" data-toggle="tab">Amenities</a></li>
                                <li><a href="#hotel-reviews" data-toggle="tab">Reviews</a></li>
                                <li><a href="#hotel-faqs" data-toggle="tab">FAQs</a></li>
                                <li><a href="#hotel-things-todo" data-toggle="tab">Things to Do</a></li>
                                <li><a href="#hotel-write-review" data-toggle="tab">Write a Review</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="hotel-description">
                                    <div class="intro table-wrapper full-width hidden-table-sms">
                                        <div class="col-sm-5 col-lg-4 features table-cell">
                                            <ul>
                                                <li><label>hotel type:</label>4 star</li>
                                                <li><label>Extra people:</label>No Charge</li>
                                                <li><label>Minimum Stay:</label>2 nights</li>
                                                <li><label>Security Deposit:</label>$279</li>
                                                <li><label>Country:</label>France</li>
                                                <li><label>City:</label>Paris</li>
                                                <li><label>Neighborhood:</label>République</li>
                                                <li><label>Cancellation:</label>strict</li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-7 col-lg-8 table-cell testimonials">
                                            <div class="testimonial style1">
                                                <ul class="slides ">
                                                    <li>
                                                        <p class="description">Always enjoyed my stay with Hilton Hotel and Resorts, top class room service and rooms have great outside views and luxury assessories. Thanks for great experience.</p>
                                                        <div class="author clearfix">
                                                            <a href="#"><img src="images/shortcodes/author1.png" alt="tour operators in trichy" title="travel agencies in trichy" width="74" height="74" /></a>
                                                            <h5 class="name">Jessica Brown<small>guest</small></h5>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <p class="description">Always enjoyed my stay with Hilton Hotel and Resorts, top class room service and rooms have great outside views and luxury assessories. Thanks for great experience.</p>
                                                        <div class="author clearfix">
                                                            <a href="#"><img src="images/shortcodes/author2.png" alt="tour operators in trichy" title="travel agencies in trichy" width="74" height="74" /></a>
                                                            <h5 class="name">Lisa Kimberly<small>guest</small></h5>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <p class="description">Always enjoyed my stay with Hilton Hotel and Resorts, top class room service and rooms have great outside views and luxury assessories. Thanks for great experience.</p>
                                                        <div class="author clearfix">
                                                            <a href="#"><img src="images/shortcodes/author1.png" alt="tour operators in trichy" title="travel agencies in trichy" width="74" height="74" /></a>
                                                            <h5 class="name">Jessica Brown<small>guest</small></h5>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="long-description">
                                        <h2>About Hilton Hotel and Resorts</h2>
                                        <p>
                                            Sed aliquam nunc eget velit imperdiet, in rutrum mauris malesuada. Quisque ullamcorper vulputate nisi, et fringilla ante convallis quis. Nullam vel tellus non elit suscipit volutpat. Integer id felis et nibh rutrum dignissim ut non risus. In tincidunt urna quis sem luctus, sed accumsan magna pellentesque. Donec et iaculis tellus. Vestibulum ut iaculis justo, auctor sodales lectus. Donec et tellus tempus, dignissim maurornare, consequat lacus. Integer dui neque, scelerisque nec sollicitudin sit amet, sodales a erat. Duis vitae condimentum ligula. Integer eu mi nisl. Donec massa dui, commodo id arcu quis, venenatis scelerisque velit.
<br /><br />
Praesent eros turpis, commodo vel justo at, pulvinar mollis eros. Mauris aliquet eu quam id ornare. Morbi ac quam enim. Cras vitae nulla condimentum, semper dolor non, faucibus dolor. Vivamus adipiscing eros quis orci fringilla, sed pretium lectus viverra. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec nec velit non odio aliquam suscipit. Sed non neque faucibus, condimentum lectus at, accumsan enim. Fusce pretium egestas cursus. Etiam consectetur, orci vel rutrum volutpat, odio odio pretium nisiodo tellus libero et urna. Sed commodo ipsum ligula, id volutpat risus vehicula in. Pellentesque non massa eu nibh posuere bibendum non sed enim. Maecenas lobortis nulla sem, vel egestas dui ullamcorper ac.
<br /><br />
Sed scelerisque lectus sit amet faucibus sodales. Proin ut risus tortor. Etiam fermentum tellus auctor, fringilla sapien et, congue quam. In a luctus tortor. Suspendisse eget tempor libero, ut sollicitudin ligula. Nulla vulputate tincidunt est non congue. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Phasellus at est imperdiet, dapibus ipsum vel, lacinia nulla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus id interdum lectus, ut elementum elit. Nullam a molestie magna. Praesent eros turpis, commodo vel justo at, pulvinar mollis eros. Mauris aliquet eu quam id ornare. Morbi ac quam enim. Cras vitae nulla condimentum, semper dolor non, faucibus dolor. Vivamus adipiscing eros quis orci fringilla, sed pretium lectus viverra.
                                        </p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="hotel-availability">
                                    <form>
                                        <div class="update-search clearfix">
                                            <div class="col-md-5">
                                                <h4 class="title">When</h4>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <label>CHECK IN</label>
                                                        <div class="datepicker-wrap">
                                                            <input type="text" name="date_from" placeholder="mm/dd/yy" class="input-text full-width" />
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <label>CHECK OUT</label>
                                                        <div class="datepicker-wrap">
                                                            <input type="text" name="date_to" placeholder="mm/dd/yy" class="input-text full-width" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <h4 class="title">Who</h4>
                                                <div class="row">
                                                    <div class="col-xs-4">
                                                        <label>ROOMS</label>
                                                        <div class="selector">
                                                            <select class="full-width">
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <label>ADULTS</label>
                                                        <div class="selector">
                                                            <select class="full-width">
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <label>KIDS</label>
                                                        <div class="selector">
                                                            <select class="full-width">
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <h4 class="visible-md visible-lg">&nbsp;</h4>
                                                <label class="visible-md visible-lg">&nbsp;</label>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <button data-animation-duration="1" data-animation-type="bounce" class="full-width icon-check animated" type="submit">SEARCH NOW</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <h2>Available Rooms</h2>
                                    <div class="room-list listing-style3 hotel">
                                        <article class="box">
                                            <figure class="col-sm-4 col-md-3">
                                                <a class="hover-effect popup-gallery" href="ajax/slideshow-popup.html" title=""><img width="230" height="161" src="images/hotels/room/1.png" alt="tour operators in trichy" title="travel agencies in trichy"></a>
                                            </figure>
                                            <div class="details col-xs-12 col-sm-8 col-md-9">
                                                <div>
                                                    <div>
                                                        <div class="box-title">
                                                            <h4 class="title">Standard Family Room</h4>
                                                            <dl class="description">
                                                                <dt>Max Guests:</dt>
                                                                <dd>3 persons</dd>
                                                            </dl>
                                                        </div>
                                                        <div class="amenities">
                                                            <i class="soap-icon-wifi circle"></i>
                                                            <i class="soap-icon-fitnessfacility circle"></i>
                                                            <i class="soap-icon-fork circle"></i>
                                                            <i class="soap-icon-television circle"></i>
                                                        </div>
                                                    </div>
                                                    <div class="price-section">
                                                        <span class="price"><small>PER/NIGHT</small>$121</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed vitae pulvinar massa idend porta nequetiam elerisque mi id, consectetur adipi deese cing elit maus fringilla bibe endum.</p>
                                                    <div class="action-section">
                                                        <a href="hotel-booking.html" title="" class="button btn-small full-width text-center">BOOK NOW</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <article class="box">
                                            <figure class="col-sm-4 col-md-3">
                                                <a class="hover-effect popup-gallery" href="ajax/slideshow-popup.html" title=""><img width="230" height="161" src="images/hotels/room/2.png" alt="tour operators in trichy" title="travel agencies in trichy"></a>
                                            </figure>
                                            <div class="details col-xs-12 col-sm-8 col-md-9">
                                                <div>
                                                    <div>
                                                        <div class="box-title">
                                                            <h4 class="title">Superior Double Room</h4>
                                                            <dl class="description">
                                                                <dt>Max Guests:</dt>
                                                                <dd>5 persons</dd>
                                                            </dl>
                                                        </div>
                                                        <div class="amenities">
                                                            <i class="soap-icon-wifi circle"></i>
                                                            <i class="soap-icon-fitnessfacility circle"></i>
                                                            <i class="soap-icon-fork circle"></i>
                                                            <i class="soap-icon-television circle"></i>
                                                        </div>
                                                    </div>
                                                    <div class="price-section">
                                                        <span class="price"><small>PER/NIGHT</small>$241</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed vitae pulvinar massa idend porta nequetiam elerisque mi id, consectetur adipi deese cing elit maus fringilla bibe endum.</p>
                                                    <div class="action-section">
                                                        <a href="hotel-booking.html" title="" class="button btn-small full-width text-center">BOOK NOW</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <article class="box">
                                            <figure class="col-sm-4 col-md-3">
                                                <a class="hover-effect popup-gallery" href="ajax/slideshow-popup.html" title=""><img width="230" height="161" src="images/hotels/room/3.png" alt="tour operators in trichy" title="travel agencies in trichy"></a>
                                            </figure>
                                            <div class="details col-xs-12 col-sm-8 col-md-9">
                                                <div>
                                                    <div>
                                                        <div class="box-title">
                                                            <h4 class="title">Deluxe Single Room</h4>
                                                            <dl class="description">
                                                                <dt>Max Guests:</dt>
                                                                <dd>4 persons</dd>
                                                            </dl>
                                                        </div>
                                                        <div class="amenities">
                                                            <i class="soap-icon-wifi circle"></i>
                                                            <i class="soap-icon-fitnessfacility circle"></i>
                                                            <i class="soap-icon-fork circle"></i>
                                                            <i class="soap-icon-television circle"></i>
                                                        </div>
                                                    </div>
                                                    <div class="price-section">
                                                        <span class="price"><small>PER/NIGHT</small>$137</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed vitae pulvinar massa idend porta nequetiam elerisque mi id, consectetur adipi deese cing elit maus fringilla bibe endum.</p>
                                                    <div class="action-section">
                                                        <a href="hotel-booking.html" title="" class="button btn-small full-width text-center">BOOK NOW</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <article class="box">
                                            <figure class="col-sm-4 col-md-3">
                                                <a class="hover-effect popup-gallery" href="ajax/slideshow-popup.html" title=""><img width="230" height="161" src="images/hotels/room/4.png" alt="tour operators in trichy" title="travel agencies in trichy"></a>
                                            </figure>
                                            <div class="details col-xs-12 col-sm-8 col-md-9">
                                                <div>
                                                    <div>
                                                        <div class="box-title">
                                                            <h4 class="title">Single Bed Room</h4>
                                                            <dl class="description">
                                                                <dt>Max Guests:</dt>
                                                                <dd>2 persons</dd>
                                                            </dl>
                                                        </div>
                                                        <div class="amenities">
                                                            <i class="soap-icon-wifi circle"></i>
                                                            <i class="soap-icon-fitnessfacility circle"></i>
                                                            <i class="soap-icon-fork circle"></i>
                                                            <i class="soap-icon-television circle"></i>
                                                        </div>

                                                    </div>
                                                    <div class="price-section">
                                                        <span class="price"><small>PER/NIGHT</small>$55</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed vitae pulvinar massa idend porta nequetiam elerisque mi id, consectetur adipi deese cing elit maus fringilla bibe endum.</p>
                                                    <div class="action-section">
                                                        <a href="hotel-booking.html" title="" class="button btn-small full-width text-center">BOOK NOW</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <a href="#" class="load-more button full-width btn-large fourty-space">LOAD MORE ROOMS</a>
                                    </div>
                                    
                                </div>
                               
                            </div>
                        
                        </div>
                    </div>
                      <?php include"sidebar.php";?>
                </div>
            </div>
        </section>
        

