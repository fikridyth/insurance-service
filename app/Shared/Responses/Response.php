<?php

namespace App\Shared\Responses;

class Response
{
    /**
     * Success response - single record
     */
    public static function successRecord(
        string $message,
        array $record,
        int $code = 200
    ): array {
        return [
            "Meta" => self::meta($message, true, $code),
            "Data" => [
                "Record" => $record
            ]
        ];
    }

    /**
     * Success response - multiple records
     */
    public static function successRecords(
        string $message,
        array $records,
        int $code = 200,
        ?array $pagination = null
    ): array {
        return [
            "Meta" => self::meta($message, true, $code, $pagination),
            "Data" => [
                "Records" => $records
            ]
        ];
    }

    /**
     * Success response without data
     */
    public static function success(
        string $message,
        int $code = 200
    ): array {
        return [
            "Meta" => self::meta($message, true, $code),
            "Data" => null
        ];
    }

    /**
     * Error response
     */
    public static function error(
        string $message,
        int $code = 400,
        $exception = null
    ): array {
        return [
            "Meta" => [
                "CorrelationId" => null,
                "Message" => $message,
                "Code" => $code,
                "Status" => false,
                "Pagination" => null,
                "ExceptionMessage" => $exception
            ],
            "Data" => null
        ];
    }

    /**
     * Meta builder
     */
    private static function meta(
        string $message,
        bool $status,
        int $code,
        ?array $pagination = null
    ): array {
        return [
            "CorrelationId" => null,
            "Message" => $message,
            "Code" => $code,
            "Status" => $status,
            "Pagination" => $pagination,
            "ExceptionMessage" => null
        ];
    }

    /**
     * Pagination builder
     */
    public static function pagination(
        int $page,
        int $limit,
        int $totalRecord
    ): array {

        $totalPage = (int) ceil($totalRecord / $limit);

        return [
            "Page" => $page,
            "Limit" => $limit,
            "TotalRecord" => $totalRecord,
            "TotalPage" => $totalPage,
            "NextPage" => $page < $totalPage,
            "PreviousPage" => $page > 1,
            "NextPageUrl" => null,
            "PreviousPageUrl" => null,
            "FilterColumn" => null,
            "SearchTerm" => null,
            "OrderBy" => null
        ];
    }
}