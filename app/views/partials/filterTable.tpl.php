<tr>
    <td scope="col"><?= $transactionId + 1; ?></td>
    <td scope="col">
        <?php
        if ($transaction->getDate() != null) {
            echo date('d/m/Y', strtotime($transaction->getDate()));
        }
        if ($transaction->getDateTransfer() != null) {
            echo date('d/m/Y', strtotime($transaction->getDateTransfer()));
        }
        ?>
    </td>
    <td scope="col">
        <?php
        if ($transaction->getTitle() != null) {
            echo $transaction->getTitle();
        }
        if ($transaction->getTitleTransfer() != null) {
            echo $transaction->getTitleTransfer();
        }
        ?>
    </td>
    <td scope="col">
        <?=
            empty($transaction->getSum()) || $transaction->getSum() == '0.00' ? '' : $transaction->getSum() . ' €';
        ?>
    </td>
    <td scope="col">
        <?=
            empty($transaction->getTransferAmount()) || $transaction->getTransferAmount() == '0.00' ? '' : $transaction->getTransferAmount() . ' €';
        ?>
    </td>
</tr>