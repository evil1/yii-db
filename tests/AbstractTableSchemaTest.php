<?php

declare(strict_types=1);

namespace Yiisoft\Db\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Db\Tests\Support\Stub\Column;
use Yiisoft\Db\Tests\Support\Stub\TableSchema;
use Yiisoft\Db\Tests\Support\TestTrait;

abstract class AbstractTableSchemaTest extends TestCase
{
    use TestTrait;

    public function testGetCatalogName(): void
    {
        $tableSchema = new TableSchema();

        $this->assertNull($tableSchema->getCatalogName());

        $tableSchema->catalogName('test');

        $this->assertSame('test', $tableSchema->getCatalogName());
    }

    public function testGetComment(): void
    {
        $tableSchema = new TableSchema();

        $this->assertNull($tableSchema->getComment());

        $tableSchema->comment('test');

        $this->assertSame('test', $tableSchema->getComment());
    }

    public function testGetColumn(): void
    {
        $column = new Column('id');
        $tableSchema = new TableSchema();

        $this->assertNull($tableSchema->getColumn('id'));

        $tableSchema->column('id', $column);

        $this->assertSame($column, $tableSchema->getColumn('id'));
    }

    public function testGetColumns(): void
    {
        $column = new Column('id');
        $tableSchema = new TableSchema();

        $this->assertSame([], $tableSchema->getColumns());

        $tableSchema->column('id', $column);

        $this->assertSame(['id' => $column], $tableSchema->getColumns());
    }

    public function testGetColumnName(): void
    {
        $column = new Column('id');
        $tableSchema = new TableSchema();

        $this->assertNull($tableSchema->getColumn('id'));

        $tableSchema->column('id', $column);

        $this->assertSame(['id'], $tableSchema->getColumnNames());
    }

    public function testGetCreateSql(): void
    {
        $tableSchema = new TableSchema();

        $this->assertNull($tableSchema->getCreateSql());

        $tableSchema->createSql(
            <<<SQL
            CREATE TABLE `test` (`id` int(11) NOT NULL)
            SQL,
        );

        $this->assertSame(
            <<<SQL
            CREATE TABLE `test` (`id` int(11) NOT NULL)
            SQL,
            $tableSchema->getCreateSql(),
        );
    }

    public function testGetForeignKeys(): void
    {
        $tableSchema = new TableSchema();

        $this->assertSame([], $tableSchema->getForeignKeys());

        $tableSchema->foreignKeys(['id']);

        $this->assertSame(['id'], $tableSchema->getForeignKeys());
    }

    public function testGetForeignKeysAndForeingKey(): void
    {
        $tableSchema = new TableSchema();

        $this->assertSame([], $tableSchema->getForeignKeys());

        $tableSchema->foreignKey('id', ['test', 'id']);

        $this->assertSame(['id' => ['test', 'id']], $tableSchema->getForeignKeys());
    }

    public function testGetFullName(): void
    {
        $tableSchema = new TableSchema();

        $this->assertEmpty($tableSchema->getFullName());

        $tableSchema->fullName('test');

        $this->assertSame('test', $tableSchema->getFullName());
    }

    public function testGetName(): void
    {
        $tableSchema = new TableSchema();

        $this->assertEmpty($tableSchema->getName());

        $tableSchema->name('test');

        $this->assertSame('test', $tableSchema->getName());
    }

    public function testGetPrimaryKey(): void
    {
        $tableSchema = new TableSchema();

        $this->assertSame([], $tableSchema->getPrimaryKey());

        $tableSchema->primaryKey('id');

        $this->assertSame(['id'], $tableSchema->getPrimaryKey());
    }

    public function testGetSequencName(): void
    {
        $tableSchema = new TableSchema();

        $this->assertEmpty($tableSchema->getSequenceName());

        $tableSchema->sequenceName('test');

        $this->assertSame('test', $tableSchema->getSequenceName());
    }

    public function testGetServerName(): void
    {
        $tableSchema = new TableSchema();

        $this->assertEmpty($tableSchema->getServerName());

        $tableSchema->serverName('test');

        $this->assertSame('test', $tableSchema->getServerName());
    }

    public function testGetSchemaName(): void
    {
        $tableSchema = new TableSchema();

        $this->assertNull($tableSchema->getSchemaName());

        $tableSchema->schemaName('test');

        $this->assertSame('test', $tableSchema->getSchemaName());
    }
}
