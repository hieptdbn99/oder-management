
  <div class="modal fade" id="infoOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Thông tin đơn hàng</h5>
          <button type="button" class="close closeInfo" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body info-modal-body">
            <div class="form-group">
                <label for="">Họ và tên khách hàng</label>
                <p id="info_name"></p>
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <p id="info_email"></p>
            </div>
            <div class="form-group">
                <label for="">Số điện thoại</label>
                <p id="info_phone"></p>
            </div>
            <div class="form-group">
                <label for="">Địa chỉ</label>
                <p id="info_address"></p>
            </div>
            <div class="form-group">
                <label for="">Sản phẩm</label>
                <div class ="">
                  <table id="example" class="display table-striped table-bordered" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Giá thành</th>
                            <th>số lượng</th>
                        </tr>
                    </thead>
                    <tbody class="editProduct">
                     
                     
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-group">
                <label>Tổng tiền: </label>
                <p id="info_total_price"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary closeInfo" data-dismiss="modal">Đóng</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    </div>