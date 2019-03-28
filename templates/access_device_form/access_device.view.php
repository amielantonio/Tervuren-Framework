<?php var_dump($shared); ?>

<section class="">
    <h1>Access Device Forms </h1>
</section>


<section class="add-buildings">
    <form id="access-device-form">
        <div>
            <label for="ps-no">PS Number</label>
            <input type="text" name="ps-no" class="" id="ps-no">
        </div>
    </form>
</section>


<section class="view-buildings section-table">

    <form id="access-device-table-form" class="" method="post">

        <table id="access-device-buildings">
            <thead>
            <tr>
                <th></th>
                <th>PS Number</th>
                <th>Building Address</th>
                <th>Options</th>
                <th>Comments</th>
                <th>Date Added</th>
            </tr>
            </thead>

            <tbody>
                <?php ?>
                <tr>
                    <td>
                        <input type="checkbox" name="checked[]">
                    </td>
                    <td>

                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php ?>
            </tbody>

            <tfoot>
            <tr>
                <th></th>
                <th>PS Number</th>
                <th>Building Address</th>
                <th>Options</th>
                <th>Comments</th>
                <th>Date Added</th>
            </tr>
            </tfoot>

        </table>
    </form>

</section>
