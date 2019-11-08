<?php
global $post;

echo $remaining = get_post_meta( $post->ID, $this->prefix . '_remaining_debt', true );
echo $paid = get_post_meta( $post->ID, $this->prefix . '_paid_amount', true );
echo $yearly_interest = get_post_meta( $post->ID, $this->prefix . '_yearly_interest', true );
?>
<div class="dcm-meta-box">
	<p>
		<label for="_remaining_debt">Remaining</label>
		<input type="text" name="<?php echo $this->prefix; ?>_remaining_debt" id="_remaining_debt"
		       value="<?php echo $remaining; ?>"/>
	</p>

	<p>
		<label for="_paid_amount">Paid</label>
		<input type="text" name="<?php echo $this->prefix; ?>_paid_amount" id="_paid_amount"
		       value="<?php echo $paid; ?>"/>
	</p>

	<p>
		<label for="_yearly_interest">Yearly Interest</label>
		<input type="text" name="<?php echo $this->prefix; ?>_paid_amount" id="_yearly_interest"
		       value="<?php echo $yearly_interest; ?>"/>
	</p>

</div>