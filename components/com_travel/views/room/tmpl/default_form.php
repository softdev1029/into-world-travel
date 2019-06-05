<?php
$id_room = JRequest::getVar('room');
$region = $this->region;
$row = $this->row;
$data = $this->data;
$user = $this->user;
?>
<div class="zen-booking-contacts-wrapper">
    <div class="zen-booking-contacts">
        <div class="zen-booking-contacts-title">
            Contact details
        </div>
        <div class="zen-booking-contacts-subtitle">
            Please fill in all fields
        </div>

        <h2>Rooms 1</h2>
        <input type="hidden" name="data[rooms]" value="<?= $data['rooms'] ?>" />
        <div class="zen-booking-contacts-form">
            <div class="zen-booking-contacts-form-main">




                <div class="zen-booking-contacts-form-main-email">
                    <div id="data_email" class="zensuggestfield">
                        <label class="zen-form-field">
                            <div class="zen-form-field-title">
                                E-mail
                            </div>
                            <input class="zen-form-field-input" type="text" placeholder="example@mail.com" value="<?= ($user->id ? $user->email : '') ?>"   name="data[email]" aria-label="example@mail.com">

                        </label>
                    </div>
                </div>





                <div class="zen-booking-contacts-form-main-firstname">
                    <label class="zen-form-field">
                        <div class="zen-form-field-title">
                            Title
                        </div>
                        <select name='data[mann][title][]' class="zen-booking-select-list">
                            <option value="MR">MR</option>
                            <option value="MRS">Mrs</option>
                            <option value="MS">MS</option>
                        </select>
                    </label>
                </div>

                <div id="data_first0" class="zen-booking-contacts-form-main-firstname">
                    <label class="zen-form-field">
                        <div class="zen-form-field-title">
                            Name
                        </div>
                        <input class="zen-form-field-input" type="text" placeholder="Oliver" value="<?= ($user->id ? $user->name : '') ?>" name='data[mann][first][]'  >

                    </label>
                </div>
                <div id="data_last0"  class="zen-booking-contacts-form-main-lastname">
                    <label class="zen-form-field">
                        <div class="zen-form-field-title">
                            Surname
                        </div>
                        <input class="zen-form-field-input" type="text" placeholder="Smith" value="" name='data[mann][last][]' aria-label="Smith">

                    </label>
                </div>
                <div id="data_phone"  class="zen-booking-contacts-form-main-phone">
                    <label class="zen-form-field">
                        <div class="zen-form-field-title">
                            Phone for communication
                        </div> 
                        <input id="phone_fleds" class="zen-form-field-input" type="tel" placeholder="+491778826937" value="" name="data[phone]" aria-label="+7 903 1234567">

                    </label>
                </div>
                <div class="zen-booking-contacts-form-main-residence">
                </div>
            </div>
            <div class="zen-booking-contacts-form-rooms">
                <div class="zen-booking-contacts-form-room">

                    <!-----------------------  ------------------------>
                    <div   class="zen-booking-contacts-form-room-guests">

                        <?php if ($data['mann'] > 1): ?>
                            <?php for ($i = 1; $i < $data['mann']; $i++): ?>
                                <div class="zen-booking-contacts-form-guest">



                                    <div class="zen-booking-contacts-form-guest-title">
                                        Second guest name
                                    </div>
                                    <div class="zen-booking-contacts-form-guest-fields">
                                        <div class="zen-booking-contacts-form-main-firstname">
                                            <label class="zen-form-field">
                                                <div class="zen-form-field-title">
                                                    Title
                                                </div>
                                                <select name='data[mann][title][]' class="zen-booking-select-list">
                                                    <option value="MR">MR</option>
                                                    <option value="MRS">Mrs</option>
                                                    <option value="MS">MS</option>
                                                </select>
                                            </label>
                                        </div>


                                        <div id="data_first<?= $i ?>" class="zen-booking-contacts-form-guest-firstname">
                                            <label class="zen-form-field">
                                                <div class="zen-form-field-title">
                                                    Name
                                                </div>
                                                <input class="zen-form-field-input" type="text" placeholder="Oliver" value="" name="data[mann][first][]" aria-label="Иван">
                                                <div class="zen-form-field-tip">
                                                    <div class="zenpopuptipcontainer">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div id="data_last<?= $i ?>" class="zen-booking-contacts-form-guest-lastname">
                                            <label class="zen-form-field">
                                                <div class="zen-form-field-title">
                                                    Surname
                                                </div>
                                                <input class="zen-form-field-input" type="text" placeholder="Smith" value="" name="data[mann][last][]" aria-label="Smith">
                                                <div class="zen-form-field-tip">
                                                    <div class="zenpopuptipcontainer">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>

                        <?php if ($data['kind'] > 0): ?>
                            <?php for ($i = 0; $i < $data['kind']; $i++): ?>
                                <div class="zen-booking-contacts-form-guest">
                                    <div class="zen-booking-contacts-form-guest-title">
                                        Child's name (<?= $data['age' . ($i + 1)] ?> years)
                                    </div>
                                    <div class="zen-booking-contacts-form-guest-fields">

                                        <div class="zen-booking-contacts-form-main-firstname">
                                            <label class="zen-form-field">
                                                <div class="zen-form-field-title">
                                                    Title
                                                </div>
                                                <select name='data[kind][title][]' class="zen-booking-select-list">
                                                    <option value="MR">MR</option>
                                                    <option value="MRS">Mrs</option>
                                                    <option value="MS">MS</option>
                                                </select>
                                            </label>
                                        </div>

                                        <div id="kind_first<?= $i ?>" class="zen-booking-contacts-form-guest-firstname">
                                            <label class="zen-form-field">
                                                <div class="zen-form-field-title">
                                                    Name
                                                </div>
                                                <input class="zen-form-field-input" type="text" placeholder="Oliver" value="" name='data[kind][first][]' aria-label="Иван">
                                                <div class="zen-form-field-tip">
                                                    <div class="zenpopuptipcontainer">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div id="kind_last<?= $i ?>"  class="zen-booking-contacts-form-guest-lastname">
                                            <label class="zen-form-field">
                                                <div class="zen-form-field-title">
                                                    Surname
                                                </div>
                                                <input class="zen-form-field-input" type="text" placeholder="Smith" value="" name='data[kind][last][]' aria-label="Smith">
                                                <div class="zen-form-field-tip">
                                                    <div class="zenpopuptipcontainer">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>

                        <?php if ($data['rooms'] == 2): ?>
                            <h2>Rooms 2</h2>
                            <!----------------------- rooms 2 ------------------------>


                            <?php for ($i = 0; $i < $data['mann_two']; $i++): ?>
                                <div class="zen-booking-contacts-form-guest">



                                    <div class="zen-booking-contacts-form-guest-title">
                                        First guest name
                                    </div>
                                    <div class="zen-booking-contacts-form-guest-fields">
                                        <div class="zen-booking-contacts-form-main-firstname">
                                            <label class="zen-form-field">
                                                <div class="zen-form-field-title">
                                                    Title
                                                </div>
                                                <select name='data[mann_two][title][]' class="zen-booking-select-list">
                                                    <option value="MR">MR</option>
                                                    <option value="MRS">Mrs</option>
                                                    <option value="MS">MS</option>
                                                </select>
                                            </label>
                                        </div>


                                        <div id="data_first_two<?= $i ?>" class="zen-booking-contacts-form-guest-firstname">
                                            <label class="zen-form-field">
                                                <div class="zen-form-field-title">
                                                    Name
                                                </div>
                                                <input class="zen-form-field-input" type="text" placeholder="Oliver" value="" name="data[mann_two][first][]" aria-label="Иван">
                                                <div class="zen-form-field-tip">
                                                    <div class="zenpopuptipcontainer">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div id="data_last_two<?= $i ?>" class="zen-booking-contacts-form-guest-lastname">
                                            <label class="zen-form-field">
                                                <div class="zen-form-field-title">
                                                    Surname
                                                </div>
                                                <input class="zen-form-field-input" type="text" placeholder="Smith" value="" name="data[mann_two][last][]" aria-label="Smith">
                                                <div class="zen-form-field-tip">
                                                    <div class="zenpopuptipcontainer">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>


                            <?php if ($data['kind_two'] > 0): ?>
                                <?php for ($i = 0; $i < $data['kind_two']; $i++): ?>
                                    <div class="zen-booking-contacts-form-guest">
                                        <div class="zen-booking-contacts-form-guest-title">
                                            Child's name (<?= $data['age' . ($i + 1)] ?> years)
                                        </div>
                                        <div class="zen-booking-contacts-form-guest-fields">

                                            <div class="zen-booking-contacts-form-main-firstname">
                                                <label class="zen-form-field">
                                                    <div class="zen-form-field-title">
                                                        Title
                                                    </div>
                                                    <select name='data[kind_two][title][]' class="zen-booking-select-list">
                                                        <option value="MR">MR</option>
                                                        <option value="MRS">Mrs</option>
                                                        <option value="MS">MS</option>
                                                    </select>
                                                </label>
                                            </div>

                                            <div id="kind_first_two<?= $i ?>" class="zen-booking-contacts-form-guest-firstname">
                                                <label class="zen-form-field">
                                                    <div class="zen-form-field-title">
                                                        Name
                                                    </div>
                                                    <input class="zen-form-field-input" type="text" placeholder="Oliver" value="" name='data[kind_two][first][]' aria-label="Иван">
                                                    <div class="zen-form-field-tip">
                                                        <div class="zenpopuptipcontainer">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div id="kind_last_two<?= $i ?>"  class="zen-booking-contacts-form-guest-lastname">
                                                <label class="zen-form-field">
                                                    <div class="zen-form-field-title">
                                                        Surname
                                                    </div>
                                                    <input class="zen-form-field-input" type="text" placeholder="Smith" value="" name='data[kind_two][last][]' aria-label="Smith">
                                                    <div class="zen-form-field-tip">
                                                        <div class="zenpopuptipcontainer">
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>

                            <!----------------------- rooms 2 ------------------------>
                        <?php endif; ?>



                    </div>

                    <!-----------------------  ------------------------>

                    <div class="zen-booking-contacts-form-room-toggle zen-booking-contacts-form-room-toggle-show">
                        Indicate the names of all guests
                    </div>
                </div>
            </div>
            <div class="zen-booking-contacts-form-arrival-details">
                <div class="arrivaldetails">
                    <h2 class="arrivaldetails-title">
                        Information about the booking
                    </h2>
                    <div class="arrivaldetails-time">

                        <div class="arrivaldetails-requests">
                            <div class="arrivaldetails-requests-question">
                                Are there any special requests?
                            </div>
                            <div class="arrivaldetails-requests-label">
                                Write the hotel for special requests (eg view, floor, check in/check out time etc)
                            </div>
                            <div class="arrivaldetails-requests-field-wrapper">
                                <span class="arrivaldetails-requests-field-tip">
                                    Your wishes
                                </span>
                                <div class="arrivaldetails-requests-field-button-wrapper">
                                    <div class="arrivaldetails-requests-field-button">
                                    </div>
                                </div>
                                <textarea class="arrivaldetails-requests-field" name="user_comment" maxlength="255"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    jQuery(document).ready(function () {




        jQuery(document).on('click', '.zen-booking-contacts-form-room-toggle', function () {
            var obj = jQuery(this);


            if (obj.hasClass('zen-booking-contacts-form-room-toggle-show')) {


                obj.removeClass('zen-booking-contacts-form-room-toggle-show');
                obj.addClass('zen-booking-contacts-form-room-toggle-hide');

                jQuery('.zen-booking-contacts-form-room-guests').show();
            }
            else
            {
                obj.removeClass('zen-booking-contacts-form-room-toggle-hide');
                obj.addClass('zen-booking-contacts-form-room-toggle-show');
                jQuery('.zen-booking-contacts-form-room-guests').hide();
            }


            return false;
        });

        jQuery('.zen-booking-contacts-form-room-toggle').trigger('click');
        jQuery(document).on('click', '.arrivaldetails-requests-question', function () {
            var obj = jQuery(this);
            jQuery('.arrivaldetails').removeClass('arrivaldetails-hidden-request');

            return false;
        });

        jQuery(document).on('click', '.arrivaldetails-requests-field-button', function () {
            var obj = jQuery(this);
            jQuery('.arrivaldetails').addClass('arrivaldetails-hidden-request');
            return false;
        });



    });
</script>

