<?php

declare(strict_types=1);

namespace Yiisoft\Db\QueryBuilder\Condition;

use Yiisoft\Db\Exception\InvalidArgumentException;
use Yiisoft\Db\Expression\ExpressionInterface;
use Yiisoft\Db\QueryBuilder\Condition\Interface\NotConditionInterface;

use function array_shift;
use function count;

/**
 * Condition that inverts passed {@see condition}.
 */
final class NotCondition implements NotConditionInterface
{
    public function __construct(private ExpressionInterface|array|null|string $condition)
    {
    }

    public function getCondition(): ExpressionInterface|array|null|string
    {
        return $this->condition;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function fromArrayDefinition(string $operator, array $operands): self
    {
        return new self(self::validateCondition($operator, $operands));
    }

    private static function validateCondition(string $operator, array $condition): ExpressionInterface|array|null|string
    {
        if (count($condition) !== 1) {
            throw new InvalidArgumentException("Operator '$operator' requires exactly one operand.");
        }

        /** @var mixed $condition */
        $condition = array_shift($condition);

        if (
            !is_array($condition) &&
            !($condition instanceof ExpressionInterface) &&
            !is_string($condition) &&
            $condition !== null
        ) {
            throw new InvalidArgumentException(
                "Operator '$operator' requires condition to be array, string, null or ExpressionInterface."
            );
        }

        return $condition;
    }
}