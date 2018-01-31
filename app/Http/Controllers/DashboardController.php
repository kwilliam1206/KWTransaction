<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use KW\Transactions\Models\Task;
use KW\Transactions\Models\Transaction;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $widgets = new \stdClass();
        $widgets->rows = [0 => [], 1 => [], 2 => []];

        if (Auth::user()->can('approve_transaction')) {
            //MCA dashboard

            $widget = new \stdClass();
            $widget->id = 'mc_appointments';
            $widget->type = 'knob';
            $widget->title = 'Recruiting Appointments';
            $widget->actions = [];
            $widget->fgColor = '#009999';
            $widget->bgColor = '#85e0e0';
            $widget->data = ['label'=>'Appointments', 'value'=>'97', 'percentage'=>48];

            $widgets->rows[0][] = $widget;

            $widget = new \stdClass();
            $widget->id = 'mc_listings_volume';
            $widget->type = 'badge';
            $widget->title = 'Listings Volume';
            $widget->actions = [];
            $widget->bgColor = '#5cb85c';
            $widget->data = ['label'=>'August 2016', 'value'=>'$1.76M', 'trendingValue'=>10];

            $widgets->rows[0][] = $widget;

            $widget = new \stdClass();
            $widget->id = 'mc_units_closed';
            $widget->type = 'knob';
            $widget->title = 'Closed Units';
            $widget->actions = [];
            $widget->fgColor = '#f05050';
            $widget->bgColor = '#F9B9B9';
            $widget->data = ['label'=>'August 2016', 'value'=>8, 'percentage'=>63];

            $widgets->rows[0][] = $widget;

            $widget = new \stdClass();
            $widget->id = 'mc_revenue';
            $widget->type = 'badge';
            $widget->title = 'Revenue';
            $widget->actions = [];
            $widget->bgColor = '#336600';
            $widget->data = ['label'=>'Year To Date', 'value'=>'$245,167.12', 'trendingValue'=>3];

            $widgets->rows[0][] = $widget;



            $widget = new \stdClass();
            $widget->id = 'mc_gross_agent_increase';
            $widget->type = 'bar';
            $widget->title = 'Gross Agent Increase';
            $widget->actions = [];
            $widget->xkey = 'y';
            $widget->ykeys = ['a','b'];
            $widget->labels = ['Last Year', 'This Year'];
            $widget->gridLineColor = '#eeeeee';
            $widget->barSizeRatio = 0.25;
            $widget->stacked = true;
            $widget->barColors = ['#c3c3c3', '#ff5b5b'];
            $widget->data = [];

            $dp = new \stdClass();
            $dp->y = 'MAY';
            $dp->a = 24;
            $dp->b = 45;
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->y = 'JUN';
            $dp->a = 24;
            $dp->b = 63;
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->y = 'JUL';
            $dp->a = 12;
            $dp->b = 84;
            $widget->data[] = $dp;

            $widgets->rows[1][] = $widget;


            $widget = new \stdClass();
            $widget->id = 'mc_net_agent_increase';
            $widget->type = 'line';
            $widget->title = 'Net Agent Increase';
            $widget->actions = [];
            $widget->xkey = 'y';
            $widget->ykeys = ['a','b'];
            $widget->labels = ['This Year', 'Last Year'];
            $widget->fillOpacity = ['0.9'];
            $widget->gridLineColor = '#eef0f2';
            $widget->lineColors = ['#ff5b5b', '#c3c3c3'];
            $widget->pointFillColors = ['#ffffff'];
            $widget->pointStrokeColors = ['#999999'];
            $widget->data = [];

            $dp = new \stdClass();
            $dp->y = 'MAY';
            $dp->a = 23;
            $dp->b = 20;
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->y = 'JUN';
            $dp->a = 33;
            $dp->b = 16;
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->y = 'JUL';
            $dp->a = 48;
            $dp->b = 8;
            $widget->data[] = $dp;

            $widgets->rows[1][] = $widget;



            $widget = new \stdClass();
            $widget->id = 'mc_cappers';
            $widget->type = 'donut';
            $widget->title = 'Cappers';
            $widget->actions = [];
            $widget->label = 'Total Agents in MC: 41';
            $widget->colors = ['#ff9900', '#10c469', "#188ae2", "#cdcdcd"];
            $widget->data = [];

            $dp = new \stdClass();
            $dp->label = 'Cappers';
            $dp->value = 9;
            $dp->color = '#ff9900';
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->label = 'Half-Cappers';
            $dp->value = 16;
            $dp->color = '#10c469';
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->label = 'Quarter-Cappers';
            $dp->value = 12;
            $dp->color = '#188ae2';
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->label = 'Other';
            $dp->value = 4;
            $dp->color = '#cdcdcd';
            $widget->data[] = $dp;

            $widgets->rows[1][] = $widget;



            $widget = new \stdClass();
            $widget->id = 'mc_transactions_status';
            $widget->type = 'donut';
            $widget->title = 'Transactions';
            $widget->actions = [];
            $widget->colors = ['#ff9900', '#cc3300', "#ff6600", "#009933"];
            $widget->data = [];

            $dp = new \stdClass();
            $dp->label = 'Submitted';
            $dp->value = 13;
            $dp->color = '#ff9900';
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->label = 'Accepted';
            $dp->value = 10;
            $dp->color = '#cc3300';
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->label = 'Pending';
            $dp->value = 2;
            $dp->color = '#ff6600';
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->label = 'Completed';
            $dp->value = 8;
            $dp->color = '#009933';
            $widget->data[] = $dp;

            $widgets->rows[2][] = $widget;



        } else {
            //Agent dashboard

            $widget = new \stdClass();
            $widget->id = 'agent_listings_volume';
            $widget->type = 'badge';
            $widget->title = 'Listings Volume';
            $widget->actions = [];
            $widget->bgColor = '#5cb85c';
            $widget->data = ['label'=>'August 2016', 'value'=>'$82,356.37', 'trendingValue'=>21, 'progress'=>70, 'progressColor'=>'rgba(16, 196, 105, 0.2)'];

            $widgets->rows[0][] = $widget;

            $widget = new \stdClass();
            $widget->id = 'agent_contracts_written';
            $widget->type = 'badge_2';
            $widget->title = 'Contracts Written';
            $widget->actions = [];
            $widget->bgColor = '#ffbd4a';
            $widget->data = ['label'=>'Total Volume', 'value'=>'$1.25M', 'count'=>12];

            $widgets->rows[0][] = $widget;

            $widget = new \stdClass();
            $widget->id = 'agent_units_closed';
            $widget->type = 'knob';
            $widget->title = 'Closed Units';
            $widget->actions = [];
            $widget->fgColor = '#f05050';
            $widget->bgColor = '#F9B9B9';
            $widget->data = ['label'=>'Units last 3 months', 'value'=>6, 'percentage'=>69];

            $widgets->rows[0][] = $widget;

            $widget = new \stdClass();
            $widget->id = 'agent_cap_status';
            $widget->type = 'badge_2';
            $widget->title = 'Cap Status';
            $widget->actions = [];
            $widget->bgColor = '#ffbd4a';
            $widget->data = ['label'=>'Remaining Cap', 'value'=>'$32,700.40'];

            $widgets->rows[0][] = $widget;


            $widget = new \stdClass();
            $widget->id = 'agent_listings_mom';
            $widget->type = 'bar';
            $widget->title = 'Listings (Active vs Sold)';
            $widget->actions = [];
            $widget->xkey = 'y';
            $widget->ykeys = ['a','b'];
            $widget->labels = ['Active', 'Sold'];
            $widget->gridLineColor = '#eeeeee';
            $widget->barSizeRatio = 0.5;
            $widget->stacked = false;
            $widget->barColors = ['#188ae2','#10c469'];
            $widget->data = [];

            $dp = new \stdClass();
            $dp->y = 'JUN';
            $dp->a = 6;
            $dp->b = 3;
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->y = 'JUL';
            $dp->a = 7;
            $dp->b = 2;
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->y = 'AUG';
            $dp->a = 4;
            $dp->b = 1;
            $widget->data[] = $dp;

            $widgets->rows[1][] = $widget;

            $widget = new \stdClass();
            $widget->id = 'agent_revenue_mom';
            $widget->type = 'line';
            $widget->title = 'Revenue';
            $widget->actions = [];
            $widget->xkey = 'y';
            $widget->ykeys = ['a','b'];
            $widget->labels = ['This Year', 'Last Year'];
            $widget->fillOpacity = ['0.9'];
            $widget->gridLineColor = '#eef0f2';
            $widget->lineColors = ['#ff5b5b', '#c3c3c3'];
            $widget->pointFillColors = ['#ffffff'];
            $widget->pointStrokeColors = ['#999999'];
            $widget->data = [];

            $dp = new \stdClass();
            $dp->y = 'JUN';
            $dp->a = 16000;
            $dp->b = 13500;
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->y = 'JUL';
            $dp->a = 24000;
            $dp->b = 17800;
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->y = 'AUG';
            $dp->a = 9200;
            $dp->b = 16500;
            $widget->data[] = $dp;

            $widgets->rows[1][] = $widget;

            $widget = new \stdClass();
            $widget->id = 'agent_cgi_tracker';
            $widget->type = 'donut';
            $widget->title = 'CGI Goal';
            $widget->actions = [];
            $widget->label = '83 Appointments Needed';
            $widget->height = '208px';
            $widget->colors = ['#FFE6BA', '#ffbd4a'];
            $widget->data = [];

            $dp = new \stdClass();
            $dp->label = 'Remaining (%)';
            $dp->value = 35;
            $dp->color = '#ffbd4a';
            $widget->data[] = $dp;

            $dp = new \stdClass();
            $dp->label = 'Completed (%)';
            $dp->value = 65;
            $dp->color = '#FFE6BA';
            $widget->data[] = $dp;

            $widgets->rows[1][] = $widget;

        }

        $user = Auth::user();
        $tasks = Task::with(['transaction','office'])->forOfficeOrUser($request->cookie('kw_office'), $user->id)->incomplete()->take(10)->get();

        $transactions = Transaction::with(['status','agent','office'])->forOffice($request->cookie('kw_office'))->orderBy('status_change_date', 'desc')->take(10)->get();

        /*
Agent Dashboard widgets:
Listings - listings taken (active but not yet sold) and listings sold MOM – Buyer Side, Seller Side,
        Both Buyer and Seller Side Transactions and Lease

Listings Volume – Buyer Side, Seller Side, Both Buyer and Seller Side Transactions
Units Closed - Buyer Side, Seller Side, Both Buyer and Seller Side Transactions
CGI – tracker outlined below
Contracts written/Contracts Written Volume
Revenue – MOM, YTD, Current Cap Status (how much is left until anniversary date per the MC split)

MCA Dashboard:
Total Agent Count with a snapshot of the top down report (Cappers, Half-Cappers, Quarter-Cappers)
Total Agent Count – gross and net increase MOM and YTD
Recruiting Appointments entered throughout the month and conversion ratio updated on monthly close
Transactions – Submitted, Approved, Pending Payment and Completed
The rest should be a roll-up of the agents’ metrics – Listings, Units, Revenue
         */

        return view('dashboard.index')
            ->with('widgets', $widgets)
            ->with('tasks', $tasks)
            ->with('transactions', $transactions);
    }
}
