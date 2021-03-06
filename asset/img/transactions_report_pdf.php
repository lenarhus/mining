<!DOCTYPE html>
<html>
    <head>
        <title><?= lang('transactions_report') ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            th
            {
                padding: 10px 0px 5px 5px; text-align: left; font-size: 13px; border: 1px solid black;
            }
            td
            {
                padding: 5px 0px 0px 5px; text-align: left; border: 1px solid black; font-size: 13px;
            }
        </style>

    </head>
    <body style="min-width: 98%; min-height: 100%; overflow: hidden; alignment-adjust: central;">
        <br />
        <div style="width: 100%; border-bottom: 2px solid black;">
            <table style="width: 100%; vertical-align: middle;">
                <tr>
                    <td style="width: 50px; border: 0px;">
                        <img style="width: 50px;height: 50px;margin-bottom: 5px;" src="<?= base_url() . config_item('company_logo') ?>" alt="" class="img-circle"/>
                    </td>

                    <td style="border: 0px;">
                        <p style="margin-left: 10px; font: 14px lighter;"><?= config_item('company_name') ?></p>
                    </td>
                </tr>
            </table>
        </div>
        <br />
        <div style="width: 100%;">          
            <table style="width: 100%; font-family: Arial, Helvetica, sans-serif; border-collapse: collapse;">
                <tr>
                    <th style="width: 15%"><?= lang('date') ?></th>
                    <th style="width: 15%"><?= lang('account') ?></th>
                    <th><?= lang('type') ?></th>
                    <th><?= lang('notes') ?></th>
                    <th><?= lang('amount') ?></th>
                    <th><?= lang('credit') ?></th>
                    <th><?= lang('debit') ?></th>
                    <th><?= lang('balance') ?></th>                  
                </tr>
                <?php
                $total_amount = 0;
                $total_debit = 0;
                $total_credit = 0;
                $total_balance = 0;
                $curency = $this->transactions_model->check_by(array('code' => config_item('currency')), 'tbl_currencies');
                $all_transaction_info = $this->db->order_by('transactions_id','DESC')->get('tbl_transactions')->result();
                if (!empty($all_transaction_info)): foreach ($all_transaction_info as $v_transaction) :
                        $account_info = $this->transactions_model->check_by(array('account_id' => $v_transaction->account_id), 'tbl_accounts');
                        ?>

                        <tr style="width: 100%;">
                            <td><?= strftime(config_item('date_format'), strtotime($v_transaction->date)); ?></td>
                            <td class="vertical-td"><?= $account_info->account_name ?></td>
                            <td class="vertical-td"><?= lang($v_transaction->type) ?> </td>
                            <td class="vertical-td"><?= $v_transaction->notes ?></td>
                            <td><?= $curency->symbol . ' ' . number_format($v_transaction->amount, 2) ?></td>                                                       
                            <td><?= $curency->symbol . ' ' . number_format($v_transaction->credit, 2) ?></td>                                                       
                            <td><?= $curency->symbol . ' ' . number_format($v_transaction->debit, 2) ?></td>                                                       
                            <td><?= $curency->symbol . ' ' . number_format($v_transaction->total_balance, 2) ?></td>  
                        </tr>
                        
                        <?php
                        $total_amount +=$v_transaction->amount;
                        $total_debit +=$v_transaction->debit;
                        $total_credit +=$v_transaction->credit;
                        $total_balance +=$v_transaction->total_balance;
                        ?>
                    <?php endforeach; ?>     
                    <tr class="custom-color-with-td">
                        <td style="text-align: right;" colspan="4"><strong><?= lang('total') ?>:</strong></td>
                        <td><strong><?= $curency->symbol . ' ' . number_format($total_amount, 2) ?></strong></td>
                        <td><strong><?= $curency->symbol . ' ' . number_format($total_credit, 2) ?></strong></td>
                        <td><strong><?= $curency->symbol . ' ' . number_format($total_debit, 2) ?></strong></td>
                        <td><strong><?= $curency->symbol . ' ' . number_format($total_balance, 2) ?></strong></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="7">
                            <strong>There is no Report to display</strong>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>

        </div>        
    </body>
</html>
