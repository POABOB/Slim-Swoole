<?php

declare(strict_types=1);

namespace App\Domain\Users\Service;

use App\Domain\Users\Repository\UsersRepository;
use App\Utils\ResponseFormat;
use App\Utils\Validation;

final class DeleteService {

  /** @var UsersRepository */
  private UsersRepository $repository;

  /** @var ResponseFormat */
  private ResponseFormat $res;

  /** @var Validation */
  private Validation $v;
  /**
   *
   * @param UsersRepository $repository DB操作
   * @param ResponseFormat $res 回傳固定格式
   * @param Validation $v 表單驗證
   */
  public function __construct(UsersRepository $repository, ResponseFormat $res, Validation $v)
  {
    $this->repository = $repository;
    $this->res = $res;
    $this->v = $v;
  }

  /**
   * 刪除Users
   *
   * @param array $user 資料型別
   *
   * @return array Users array
   */
  public function deleteUser(array $data): ResponseFormat
  {
    // Validation
    $this->v->validate(
      ["ID" => (!empty($data["id"]) ? $data["id"] : "")],
      ["ID" => ["required", "maxLen" => 11]]
    );

    // Invalid
    if($this->v->error()) {
      return $this->res->format(401, $this->v->error(),"提交格式有誤!");
    }

    $this->repository->deleteUser(["id" => $data["id"]]);
    return $this->res->format(200, "Success");
  }
}