<div class="box box-info box_info">
    <div class="panel-body">
    <h4 class="all_settings f-18 mt-1">Property Settings</h4>
        <?php
        $requestUri = request()->segment(4);
        ?>
        <ul class="nav navbar-pills nav-tabs nav-stacked no-margin d-flex flex-column f-14" role="tablist">
            <li class="{{ ($requestUri == 'basics') ? 'active' : ''  }}">
                <a href='{{ url("admin/listing/$result->id/basics") }}' data-group="profile">Basics</a>
            </li>

            <li class="{{ ($requestUri == 'description' || $requestUri == 'details') ? 'active' : ''  }}">
                <a href='{{ url("admin/listing/$result->id/description") }}' data-group="profile">Description</a>
            </li>

            <li class="{{ ($requestUri == 'location') ? 'active' : ''  }}">
                <a href='{{ url("admin/listing/$result->id/location") }}' data-group="profile">Location</a>
            </li>

            <li class="{{ ($requestUri == 'amenities') ? 'active' : ''  }}">
                <a href='{{ url("admin/listing/$result->id/amenities") }}' data-group="profile">Amenities</a>
            </li>

            <li class="{{ ($requestUri == 'photos') ? 'active' : ''  }}">
                <a href='{{ url("admin/listing/$result->id/photos") }}' data-group="profile">Photos</a>
            </li>

            <li class="{{ ($requestUri == 'pricing') ? 'active' : ''  }}">
                <a href='{{ url("admin/listing/$result->id/pricing") }}' data-group="profile">Pricing</a>
            </li>

            <li class="{{ ($requestUri == 'booking') ? 'active' : ''  }}">
                <a href='{{ url("admin/listing/$result->id/booking") }}' data-group="profile">Booking</a>
            </li>

            <li class="{{ ($requestUri == 'calender') ? 'active' : ''  }}">
                <a href='{{ url("admin/listing/$result->id/calender") }}' data-group="profile">Calendar</a>
            </li>

            <li class="{{ ($requestUri == 'lease') ? 'active' : ''  }}">
                <a href='{{ url("admin/listing/$result->id/lease") }}' data-group="profile">Lease Types</a>
            </li>

        </ul>
    </div>
</div>
